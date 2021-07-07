from abc import ABCMeta, abstractproperty
from imu_model.base import Platform
from imu_model.sensors import Accelerometer, Gyroscope
from imu_model.trajectories import StaticTrajectory
from imu_model.environment import Environment



class IMU(Platform):

    def __init__(self, accelerometer=None, gyroscope=None,
                 trajectory=StaticTrajectory(), environment=Environment()):
        if accelerometer is None:
            self._accelerometer = Accelerometer(self)
        else:
            self._accelerometer = accelerometer
            self._accelerometer.set_platform(self)
        if gyroscope is None:
            self._gyroscope = Gyroscope(self)
        else:
            self._gyroscope = gyroscope
            self._gyroscope.set_platform(self)
        Platform.__init__(self, trajectory, environment)

    @property
    def environment(self):
        return self._environment

    @property
    def trajectory(self):
        return self._trajectory

    @property
    def components(self):
        return [self._accelerometer, self._gyroscope]

    @property
    def accelerometer(self):
        return self._accelerometer

    @property
    def gyroscope(self):
        return self._gyroscope

    def set_component(self, component):
        component.set_platform(self)

    def acceleration(self, time):
        return self._accelerometer(time)

    def angle_velocity(self, time):
        return self._gyroscope(time)

