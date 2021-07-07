from data_processing.processing_entity import ProcessingEntity, ProcessingDecorator
import numpy as np
import matplotlib.pyplot as plt
from imu_model.sensors import Sensor


class SensorOutput(ProcessingEntity):
    def __init__(self, sample_frequency=100):
        if sample_frequency == 0:
            sample_frequency = 100
        if sample_frequency < 0:
            sample_frequency = -sample_frequency
        self._sample_frequency = sample_frequency

    def _processing(self, sensor: Sensor, time: float, unit_reduction=False):
        timevec = np.arange(0, time, 1/self._sample_frequency)
        if unit_reduction is True:
            data = sensor.__call__(timevec)
        else:
            data = sensor.output(timevec)
        return timevec, data

    def __call__(self, sensor: Sensor, time: float, unit_reduction=False):
        return self._processing(sensor, time, unit_reduction)


class SensorOutputPlot(ProcessingDecorator):
    def __init__(self, processing_entity: ProcessingEntity,
                 title: str = "Output Signal",
                 labels=None,
                 xlabel: str = "Time, [sec]",
                 ylabel: str = "Output, [LSB]",
                 grid=True):

        super().__init__(processing_entity)
        self._title = title
        self._labels = labels
        self._xlabel = xlabel
        self._ylabel = ylabel
        self._grid = grid

    def _processing(self, *args, **kwargs):
        time, data = self._component(*args, **kwargs)
        plt.plot(time, data.T)
        plt.title(self._title)
        plt.xlabel(self._xlabel)
        plt.ylabel(self._ylabel)
        plt.grid(self._grid)
        plt.tight_layout()

        if self._labels is not None:
            plt.legend(self._labels, loc='upper right')
        plt.show()
        return time, data
