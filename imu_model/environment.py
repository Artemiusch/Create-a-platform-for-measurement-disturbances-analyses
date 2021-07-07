from imu_model.mathematics.vectors import *
from scipy.constants import g as gravity_acceleration


class Environment:
    def __init__(self, gravity=vector(0, 0, gravity_acceleration)):
        self._gravity = ConstantVectorField(gravity)

    def gravity(self, position):
        return self._gravity(position)

    @property
    def gravity_vector(self):
        return self._gravity.nominal_value

    @property
    def gravity_magnitude(self):
        return self._gravity.nominal_magnitude

