from data_processing.processing_entity import ProcessingEntity, ProcessingDecorator
import matplotlib.pyplot as plt
import numpy as np
import math
import allantools


class AllanVariance(ProcessingEntity):

    def __init__(self, sample_frequency=100):
        self._sample_frequency = sample_frequency

    def _processing(self, data):
        sample_time = 1.0 / self._sample_frequency
        data_length = len(data)
        max_sample_per_bin = int(math.floor(data_length / 9.0))  # at least 9 bins
        tau = np.zeros((max_sample_per_bin,))
        avar = np.zeros((max_sample_per_bin,))
        for i in range(1, max_sample_per_bin + 1):
            num_of_bins = int(math.floor(data_length / i))
            if num_of_bins < 9:
                break
            bin_length = int(math.floor(data_length / num_of_bins))
            tmp = np.reshape(data[0: num_of_bins * bin_length], (num_of_bins, bin_length))
            tmp = np.mean(tmp, 1)
            diff = tmp[1::] - tmp[0:-1]
            avar[i - 1] = 0.5 / (num_of_bins - 1) * np.sum(diff * diff)
            tau[i - 1] = i * sample_time
        return tau, avar


    def __call__(self, data: np.ndarray, frequency=None):
        if frequency is not None:
            self._sample_frequency = frequency
        result = np.apply_along_axis(self._processing, 1, data)
        return result

class AllanDeviation(AllanVariance):
    def __init__(self, sample_frequency=100):
        super().__init__(sample_frequency)

    def _processing(self, data):
        time, avar = super()._processing(data)
        adev = np.sqrt(avar)
        return time, adev

    def __call__(self, data: np.ndarray, frequency=None):
        if frequency is not None:
            self._sample_frequency = frequency
        result = np.apply_along_axis(self._processing, 1, data)
        return result


class ModifiedAllanVariance(ProcessingEntity):

    def __init__(self, sample_frequency=100, data_type="freq"):
        self._sample_frequency = sample_frequency
        self._data_type = data_type

    def _processing(self, data):
        (tau, avar, ade, adn) = allantools.mdev(data, rate=self._sample_frequency, data_type=self._data_type)
        return tau, avar

    def __call__(self, data, frequency=None):
        if frequency is not None:
            self._sample_frequency = frequency
        return np.apply_along_axis(self._processing, 1, data)


class AllanVariancePlot(ProcessingDecorator):
    def __init__(self, processing_entity: ProcessingEntity,
                 title: str = "Allan Variance",
                 labels=None,
                 xlabel: str = "Time, [sec]",
                 ylabel: str = "Variance, [LSB^2]",
                 grid=True):
        super().__init__(processing_entity)
        self._title = title
        self._labels = labels
        self._xlabel = xlabel
        self._ylabel = ylabel
        self._grid = grid


    def _processing(self, *args, **kwargs):
        for i in range(np.shape(result)[0]):
            plt.loglog(result[i][0], result[i][1])
        plt.title(self._title)
        plt.xlabel(self._xlabel)
        plt.ylabel(self._ylabel)
        plt.grid(self._grid)
        if self._labels is not None:
            plt.legend(self._labels, loc='upper right')
        plt.tight_layout()
        plt.show()
        return result

class AllanDeviationPlot(ProcessingDecorator):
    def __init__(self, processing_entity: ProcessingEntity,
                 title: str = "Allan Deviation",
                 labels=None,
                 xlabel: str = r"$\tau$, [$sec$]",
                 ylabel: str = r"$\sigma$, [$LSB$]",
                 grid=True):
        super().__init__(processing_entity)
        self._title = title
        self._labels = labels
        self._xlabel = xlabel
        self._ylabel = ylabel
        self._grid = grid

    def _processing(self, **kwargs):
        result = self._component(data=kwargs['data'], frequency=kwargs['frequency'] if 'frequency' in kwargs else None)
        for i in range(np.shape(result)[0]):
            plt.loglog(result[i][0], result[i][1])
        plt.title(self._title)
        plt.xlabel(self._xlabel)
        plt.ylabel(self._ylabel)
        plt.grid(self._grid)

        if self._labels is not None:
            plt.legend(self._labels, loc='upper right')
        plt.tight_layout()
        if 'filename' in kwargs:
            plt.savefig(kwargs['filename'])
        plt.show()
        return result
