from abc import ABCMeta, abstractmethod
from imu_model.trajectories import *


class Platform(metaclass=ABCMeta):

    def __init__(self, trajectory=None, environment=None):
        self._components = None
        self._environment = environment
        self._trajectory = trajectory
        self._trajectory_change()

    @property
    @abstractmethod
    def components(self):
        pass

    @property
    @abstractmethod
    def environment(self):
        pass

    @property
    @abstractmethod
    def trajectory(self):
        pass

    def trajectory(self, trajectory):
        self._trajectory = trajectory
        self._trajectory_change()

    def _trajectory_change(self):
        for component in self.components:
            component.trajectory_change()


class Component:
    def __init__(self, platform, position_offset=np.zeros((3, 1)),
                 orientation_offset=np.array([1, 0, 0, 0])):
        self._platform = platform
        self._position_offset = position_offset
        self._orientation_offset = orientation_offset

    def trajectory_change(self):
        pass

    @property
    def platform(self):
        return self._platform

    def set_platform(self, platform):
        self._platform = platform

