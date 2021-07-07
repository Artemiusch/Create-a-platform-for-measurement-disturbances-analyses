import numpy as np
from scipy.linalg import pinv


class AffineTransform:

    def __init__(self, transform=np.eye(3), translation=np.zeros((3, 1))):
        self._transform = transform
        self._translation = translation
        self._inverse_transform = pinv(self._transform)

    def apply(self, vector):
        return np.dot(self._transform, vector + self._translation)

    def reverse_apply(self, vector):
        return np.dot(self._inverse_transform, vector) - self._translation

    def __call__(self, vector):
        return self.apply(vector)

