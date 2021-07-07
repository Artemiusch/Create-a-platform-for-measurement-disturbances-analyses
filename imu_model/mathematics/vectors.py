from abc import ABCMeta, abstractmethod
import numpy as np
from scipy.linalg import norm


def vector(*components):
    return np.array([components], dtype=np.float64).T


class VectorField(metaclass=ABCMeta):

    @abstractmethod
    def __call__(self, position):
        pass

    @abstractmethod
    def nominal_value(self):
        pass

    @property
    def nominal_magnitude(self):
        return norm(self.nominal_value(), ord='fro')


class ConstantVectorField(VectorField):

    def __init__(self, value):
        self._value = value

    def __call__(self, position):
        res = np.empty_like(position)
        res[:] = self._value
        return res

    @property
    def nominal_value(self):
        return self._value

