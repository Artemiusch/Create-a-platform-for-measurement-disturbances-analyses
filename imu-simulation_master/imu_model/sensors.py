import numpy as np
from abc import ABCMeta, abstractmethod
from imu_model.base import Component
from imu_model.mathematics.transformations import *
from numpy import size


class Sensor(Component, metaclass=ABCMeta):

    def __init__(self, platform,
                 sensitivity=np.eye(3),
                 bias=np.zeros((3, 1)),
                 noisegen=None,
                 position_offset=np.zeros((3, 1)),
                 orientation_offset=np.array([1, 0, 0, 0])):
        self._noisegen = noisegen
        self._transform = AffineTransform(sensitivity, bias)
        self._trajectory = None
        Component.__init__(self, platform, position_offset, orientation_offset)

    def trajectory_change(self):
        parent_trajectory = None if self.platform is None else self.platform.trajectory
        if parent_trajectory is None:
            self._trajectory = None
        else:
            self._trajectory = parent_trajectory

    @abstractmethod
    def true_values(self, time):
        pass

    def sensed_output(self, time):
        return self._transform.apply(self.true_values(time))

    def noise_output(self, time):
        if self._noisegen is None:
            return np.zeros((3, len(time)))
        result = self._noisegen.generate(len(time))
        return result

    def output(self, time):
        return self.sensed_output(time) + self.noise_output(time)

    def __call__(self, time):
        return self._transform.reverse_apply(self.output(time))


class Accelerometer(Sensor):
    def true_values(self, time):
        gravity = self.platform.environment.gravity(self.platform.trajectory.position(time))
        out = self.platform.trajectory.acceleration(time) - gravity
        return out

class Gyroscope(Sensor):
    def true_values(self, time):
        return self.platform.trajectory.angular_velocity(time)

