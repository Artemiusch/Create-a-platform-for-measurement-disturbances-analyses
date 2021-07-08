import numpy as np


def mean_sqr(x):
    return (np.abs(x) ** 2.0).mean()


def normalize(y, x=None):
    x = mean_sqr(x) if x is not None else 1.0
    return y * np.sqrt(x / mean_sqr(y))
