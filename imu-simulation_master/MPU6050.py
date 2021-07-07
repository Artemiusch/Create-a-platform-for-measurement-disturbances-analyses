import math
import numpy as np
from scipy.constants import g
from csv import reader

from imu_model.imu import IMU
from imu_model.sensors import Accelerometer, Gyroscope

class AccelerometerMPU6050(Accelerometer):

    def __init__(self, filename, platform,
                 position_offset=np.zeros((3, 1)),
                 orientation_offset=np.array([1, 0, 0, 0])):
        sensitivity = np.diag([16384, 16384, 16384]) / g
        self._source = filename
        Accelerometer.__init__(self, platform=platform, sensitivity=sensitivity,
                               position_offset=position_offset, orientation_offset=orientation_offset)

    def true_values(self, time):
        return self.__call__(time)

    def noise_output(self, time):
        return self.output(time) - self.sensed_output(time)

    def sensed_output(self, time):
        return np.mean(self.output(time))

    def output(self, time):
        dataset = np.zeros((3, len(time)))
        dataset[:] = np.genfromtxt(self._source, delimiter=',', usecols=(0, 1, 2), max_rows=len(time)).T
        return dataset


class GyroscopeMPU6050(Gyroscope):
    def __init__(self, filename, platform,
                 position_offset=np.zeros((3, 1)),
                 orientation_offset=np.array([1, 0, 0, 0])):
        sensitivity = np.diag([131, 131, 131])
        self._source = filename
        Gyroscope.__init__(self, platform=platform, sensitivity=sensitivity,
                           position_offset=position_offset, orientation_offset=orientation_offset)

    def true_values(self, time):
        return self.__call__(time)

    def noise_output(self, time):
        return self.output(time) - self.sensed_output(time)

    def sensed_output(self, time):
        return np.mean(self.output(time))

    def output(self, time):
        dataset = np.zeros((3, len(time)))
        dataset[:] = np.genfromtxt(self._source, delimiter=',', usecols=(3, 4, 5), max_rows=len(time)).T
        return dataset


class MPU6050(IMU):

    def __init__(self, filename, sample_frequency=100, units=None):
        self._sample_frequency = math.fabs(sample_frequency)
        self._rows = 0
        self._cols = 6
        with open(filename, 'r') as file:
            for row in reader(file, delimiter=','):
                if len(row) != self._cols:
                    raise Exception('Incorrect number of columns (must be 6)')
                self._rows += 1
        self._end_time = self._rows / self._sample_frequency
        self._source = filename
        IMU.__init__(self, AccelerometerMPU6050(filename=filename, platform=self),
                     GyroscopeMPU6050(filename=filename, platform=self))

    @property
    def environment(self):
        return self._environment

    @property
    def trajectory(self):
        return self._trajectory

    @property
    def components(self):
        return [self._accelerometer, self._gyroscope]

    def set_component(self, component):
        component.set_platform(self)

    def acceleration(self, time):
        return self._accelerometer(time)

    def angle_velocity(self, time):
        return self._gyroscope(time)
