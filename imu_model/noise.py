from abc import ABCMeta, abstractmethod
import numpy as np
import matplotlib.pyplot as plt
from numpy.fft import rfft, irfft

# user modules
from imu_model.signal_processing import normalize


class AbstractNoiseGenerator(metaclass=ABCMeta):

     @abstractmethod
     def generate(self, samplen):
         pass


class ColorNoiseGenerator(AbstractNoiseGenerator):

    def __init__(self, color='white', rms=1.0, fs=100):
        self._function = _noise_generators[color]
        self._fs = fs
        if isinstance(rms, list):
            self._rms = rms
            self._channels = len(rms)
        else:
            self._rms = [rms]
            self._channels = 1

    def generate(self, samplen):
        out = np.zeros((self._channels, samplen))
        for i in range(self._channels):
            noise = self._function(samplen)
            out[i] = self._rms[i] * noise
        return out


def white(samplen, state=None):
    if state is None:
        state = np.random.RandomState()
    return state.randn(samplen)


def pink(samplen, state=None):
    noise = white(samplen, state)
    noise_spectrum = rfft(noise) / samplen
    pink_filter = np.sqrt(np.arange(noise_spectrum.size) + 1.)
    result = irfft(noise_spectrum / pink_filter).real[:samplen]
    return normalize(result, noise)



# def blue(samplen, state=None):
#     noise = white(samplen, state)
#     noise_spectrum = rfft(noise) / samplen
#     blue_filter = np.sqrt(np.arange(noise_spectrum.size))
#     result = irfft(noise_spectrum * blue_filter).real[:samplen]
#     return normalize(result, noise)


def brown(samplen, state=None):
    noise = white(samplen, state)
    noise_spectrum = rfft(noise) / samplen
    brown_filter = np.arange(noise_spectrum.size) + 1
    result = irfft(noise_spectrum / brown_filter).real[:samplen]
    return normalize(result, noise)


def violet(samplen, state=None):
    noise = white(samplen, state)
    noise_spectrum = rfft(noise) / samplen
    violet_filter = np.arange(noise_spectrum.size) + 1
    result = irfft(noise_spectrum * violet_filter).real[:samplen]
    return normalize(result, noise)

def drift(samplen, state=None):
    noise = brown(samplen, state)
    noise_spectrum = rfft(noise) / samplen
    brown_filter = np.arange(noise_spectrum.size) + 1
    result = irfft(noise_spectrum / brown_filter).real[:samplen]
    return normalize(result, noise)

_noise_generators = {
    'white': white,
    'pink': pink,
    'brown': brown,
    'violet': violet,
    'drift': drift

}

if __name__ == '__main__':
    sampling_rate = 100.0
    time = np.arange(0, 10, 1 / sampling_rate)
    generator = ColorNoiseGenerator()
    data = generator.generate(10)
    data = data[0, :]
    fourier_transform = np.fft.rfft(data)
    abs_fourier_transform = np.abs(fourier_transform)
    power_spectrum = np.square(abs_fourier_transform)
    frequency = np.linspace(0, sampling_rate / 2, len(power_spectrum))
    plt.loglog(frequency, power_spectrum, c='g')

    ps = np.abs(np.fft.fft(data)) ** 2
    time_step = 1 / 30
    freqs = np.fft.fftfreq(data.size, time_step)
    idx = np.argsort(freqs)
    plt.loglog(freqs[idx], ps[idx], 'r.')
    plt.show()
