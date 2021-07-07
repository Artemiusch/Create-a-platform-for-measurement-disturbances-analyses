from imu_model.imu import IMU
from imu_model.sensors import Accelerometer, Gyroscope
from imu_model.noise import *
from data_processing.allan_variance import AllanDeviation, AllanDeviationPlot
from data_processing.data_visualization import SensorOutput, SensorOutputPlot
from MPU6050 import MPU6050
import sys
import csv

def ideal_imu(fs, time, Simulator):
    acc = Accelerometer(platform=None)
    gyro = Gyroscope(platform=None)
    imu = IMU(accelerometer=acc, gyroscope=gyro)
    # ideal Acceloremetr
    if Simulator == 'acc':
        output_plotter = SensorOutputPlot(SensorOutput(sample_frequency=fs), labels=["Acc_x", "Acc_y", "Acc_z"])
        timevec, acc_out = output_plotter(acc, time)
        avar_plotter = AllanDeviationPlot(AllanDeviation(sample_frequency=fs), labels=["Acc_x", "Acc_y", "Acc_z"])
        avar_plotter(data=imu.acceleration(timevec))
    # ideal Gyroscope
    if Simulator == 'gyro':
        output_plotter = SensorOutputPlot(SensorOutput(sample_frequency=fs), labels=["Gyro_x", "Gyro_y", "Gyro_z"])
        timevec, gyro_out = output_plotter(gyro, time)
        avar_plotter = AllanDeviationPlot(AllanDeviation(sample_frequency=fs), labels=["Gyro_x", "Gyro_y", "Gyro_z"])
        avar_plotter(data=imu.angle_velocity(timevec))




def noise_imu(fs, time, simulator, color):
    color2 = ['white', 'pink', 'brown', 'violet', 'drift']
    if color in color2 and simulator == 'acc':
        acc = Accelerometer(platform=None, noisegen=ColorNoiseGenerator(color, rms=[1, 1, 1]))
        imu = IMU(accelerometer=acc)
        output_plotter = SensorOutputPlot(SensorOutput(sample_frequency=fs), labels=["Acc_x", "Acc_y", "Acc_z"])
        timevec, acc_out = output_plotter(acc, time)
        avar_plotter = AllanDeviationPlot(AllanDeviation(sample_frequency=fs), labels=["Acc_x", "Acc_y", "Acc_z"])
        avar_result = avar_plotter(data=imu.acceleration(timevec))

    if color in color2 and simulator == 'gyro':
        gyro = Gyroscope(platform=None, noisegen=ColorNoiseGenerator(color, rms=[1, 1, 1]))
        imu = IMU(gyroscope=gyro)
        output_plotter = SensorOutputPlot(SensorOutput(sample_frequency=fs), labels=["Gyro_x", "Gyro_y", "Gyro_z"])
        timevec, gyro_out = output_plotter(gyro, time)
        avar_plotter = AllanDeviationPlot(AllanDeviation(sample_frequency=fs), labels=["Gyro_x", "Gyro_y", "Gyro_z"])
        avar_result = avar_plotter(data=imu.angle_velocity(timevec))


def real_imu(fs, time, filename):
    # fs = 100
    # time = 100
    imu = MPU6050(filename=filename)
    #Accelerometr
    output_plotter = SensorOutputPlot(SensorOutput(sample_frequency=fs), labels=["Acc_x", "Acc_y", "Acc_z"])
    timevec, acc_out = output_plotter(imu.accelerometer, time)
    avar_plotter = AllanDeviationPlot(AllanDeviation(sample_frequency=fs), labels=["Acc_x", "Acc_y", "Acc_z"])
    avar_result = avar_plotter(data=imu.acceleration(timevec))
    #Gyroscope
    output_plotter = SensorOutputPlot(SensorOutput(sample_frequency=fs), labels=["Gyro_x", "Gyro_y", "Gyro_z"])
    timevec, gyro_out = output_plotter(imu._gyroscope, time)
    avar_plotter = AllanDeviationPlot(AllanDeviation(sample_frequency=fs), labels=["Gyro_x", "Gyro_y", "Gyro_z"])
    avar_result = avar_plotter(data=imu.angle_velocity(timevec))

# simulator = 'acc'
# fs = 100
# time = 1000


simulator = sys.argv[1]
fs = int(sys.argv[2])
time = int(sys.argv[3])

if simulator != 'real':
    try:
        color = sys.argv[4]
        # color = 'pink'
        noise_imu(fs, time, simulator, color)
    except IndexError:
        ideal_imu(fs, time, simulator)
else:
    # with open('D:/deplomse/imu_simulation-master/datasets/mpu6050_2.csv', newline='') as data:
    #     reader = csv.reader(data)
    #     row_count = sum(1 for row in reader)
    # print(row_count)
    file = sys.argv[4]
    #real_imu(fs, time, file)
    # Якщо говорити про реальну симуляцію, то в папці Dataset знаходиться 6 файлів
    real_imu(fs, time, file)
    # real_imu(fs, time, 'C:/python_project/imu_simulation-master/datasets/mpu6050_2.csv')

