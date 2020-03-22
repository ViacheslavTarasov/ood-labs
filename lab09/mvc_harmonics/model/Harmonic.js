import {EventEmitter} from "../../mvp_harmonics/EventEmitter.js";
import {HarmonicEvents} from "./HarmonicEvents.js";

export let Harmonic = class Harmonic extends EventEmitter {
    constructor() {
        super();

        this._amplitude = 1;
        this._func = 'sin';
        this._frequency = 1;
        this._phase = 0;
    }

    onUpdated(handler) {
        this.on(HarmonicEvents.UPDATED, handler);
    }

    get amplitude() {
        return this._amplitude;
    }

    set amplitude(value) {
        this._amplitude = value;
        this.emit(HarmonicEvents.UPDATED, this)
    }

    get func() {
        return this._func;
    }

    set func(value) {
        this._func = value;
        this.emit(HarmonicEvents.UPDATED, this)
    }

    get frequency() {
        return this._frequency;
    }

    set frequency(value) {
        this._frequency = value;
        this.emit(HarmonicEvents.UPDATED, this)
    }

    get phase() {
        return this._phase;
    }

    set phase(value) {
        this._phase = value;
        this.emit(HarmonicEvents.UPDATED, this)
    }
};