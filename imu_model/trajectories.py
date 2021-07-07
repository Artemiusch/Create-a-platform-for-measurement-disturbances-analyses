from abc import ABCMeta, abstractmethod
import numpy as np
import pyquaternion as q


class PositionTrajectory(metaclass=ABCMeta):

    @abstractmethod
    def position(self, time):
        pass

    @abstractmethod
    def velocity(self, time):
        pass

    @abstractmethod
    def acceleration(self, time):
        pass


class RotationTrajectory(metaclass=ABCMeta):

    @abstractmethod
    def orientation(self, time):
        pass

    @abstractmethod
    def angular_velocity(self, time):
        pass

    @abstractmethod
    def angular_acceleration(self, time):
        pass


class StaticTrajectory(PositionTrajectory, RotationTrajectory):

    def __init__(self, position=np.zeros((3, 1)), orientation=q.Quaternion()):
        self._position = position
        self._orientation = orientation

    def position(self, time):
        res = np.empty((3, len(np.atleast_1d(time))))
        res[:] = self._position
        return res

    def velocity(self, time):
        return np.zeros((3, len(np.atleast_1d(time))))

    def acceleration(self, time):
        return np.zeros((3, len(np.atleast_1d(time))))

    def orientation(self, time):
        res = np.empty((len(np.atleast_1d(time)), 4))
        res[:] = self._orientation
        return res

    def angular_velocity(self, time):
        return np.zeros((3, len(np.atleast_1d(time))))

    def angular_acceleration(self, time):
        return np.zeros((3, len(np.atleast_1d(time))))


if __name__ == '__main__':
    import matplotlib.pyplot as plt
    t = np.arange(0, 100, 0.01)
    trajectory = StaticTrajectory()
    pos = trajectory.position(t)
    plt.plot(t, pos)
    plt.show()
