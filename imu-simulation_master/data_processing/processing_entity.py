from abc import ABCMeta, abstractmethod


class ProcessingEntity(metaclass=ABCMeta):

    @abstractmethod
    def _processing(self, *args, **kwargs):
        pass

    def __call__(self, *args, **kwargs):
        return self._processing(*args, **kwargs)


class ProcessingDecorator(ProcessingEntity):

    _component: ProcessingEntity = None

    def __init__(self, processing_entity: ProcessingEntity) -> None:
        self._component = processing_entity

    @property
    def component(self):
        return self._component

    def _processing(self, *args, **kwargs):
        return self._component(*args, **kwargs)
