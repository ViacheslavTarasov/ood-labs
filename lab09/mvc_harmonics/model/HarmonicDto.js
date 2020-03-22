export let HarmonicDto = class HarmonicDto {
    static fromModel(harmonics) {
        return {
            amplitude: harmonics.amplitude,
            func: harmonics.func,
            frequency: harmonics.frequency,
            phase: harmonics.phase
        };
    };
};