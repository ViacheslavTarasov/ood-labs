import {Harmonic} from "./Harmonic.js";

export let DataTransformer = class DataTransformer {

    static createHarmonicFromDto(harmonicDto) {
        let harmonic = new Harmonic();
        harmonic.amplitude = harmonicDto.amplitude;
        harmonic.func = harmonicDto.func;
        harmonic.frequency = harmonicDto.frequency;
        harmonic.phase = harmonicDto.phase;

        return harmonic;
    }

    static createDtoFromHarmonic(harmonic) {
        return {
            amplitude: harmonic.amplitude,
            func: harmonic.func,
            frequency: harmonic.frequency,
            phase: harmonic.phase
        };
    }
};