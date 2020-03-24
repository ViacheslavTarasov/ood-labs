import {Harmonic} from "../mvc_harmonics/model/Harmonic.js";


const sinon = window.sinon;
const chai = window.chai;
const assert = chai.assert;

describe("Harmonic", function () {
    describe("set/get", function () {
        /** @type Harmonic*/
        let harmonic;
        beforeEach(function () {
            harmonic = new Harmonic();
        });

        it("set amplitude устанавливает значение амплитуды 2", function () {
            harmonic.amplitude = 2;
            assert.equal(harmonic.amplitude, 2);
        });

        it("set amplitude устанавливает значение амплитуды 5", function () {
            harmonic.amplitude = 5;
            assert.equal(harmonic.amplitude, 5);
        });

        it("set func устанавливает функцию sin", function () {
            harmonic.func = 'sin';
            assert.equal(harmonic.func, 'sin');
        });

        it("set func устанавливает функцию cos", function () {
            harmonic.func = 'cos';
            assert.equal(harmonic.func, 'cos');
        });

        it("set func выбрасывает исключение при попытке установить значение,  отличное от sin либо cos", function () {
            assert.throw(() => {
                harmonic.func = 'tg';
            }, Error);
        });

        it("set amplitude устанавливает значение частоты 2", function () {
            harmonic.frequency = 2;
            assert.equal(harmonic.frequency, 2);
        });

        it("set amplitude устанавливает значение частоты 5", function () {
            harmonic.frequency = 5;
            assert.equal(harmonic.frequency, 5);
        });
        it("set amplitude устанавливает значение фазы 2", function () {
            harmonic.phase = 2;
            assert.equal(harmonic.phase, 2);
        });

        it("set amplitude устанавливает значение фазы 5", function () {
            harmonic.phase = 5;
            assert.equal(harmonic.phase, 5);
        });
    });

    describe("onUpdated", function () {
        /** @type Harmonic*/
        let harmonic;
        let spy;
        const expectedValue = 1.33;


        beforeEach(function () {
            spy = sinon.spy();
            harmonic = new Harmonic();
            harmonic.onUpdated(spy);
        });

        it("set amplitude вызывает обработчик события с установленным значением", function () {
            harmonic.amplitude = expectedValue;
            sinon.assert.calledWith(spy, harmonic);
        });
        it("set func вызывает обработчик события с установленным значением", function () {
            harmonic.func = 'cos';
            sinon.assert.calledWith(spy, harmonic);

            harmonic.func = 'sin';
            sinon.assert.calledWith(spy, harmonic);
        });
        it("set frequency вызывает обработчик события с установленным значением", function () {
            harmonic.frequency = expectedValue;
            sinon.assert.calledWith(spy, harmonic);
        });
        it("set phase вызывает обработчик события с установленным значением", function () {
            harmonic.amplitude = expectedValue;
            sinon.assert.calledWith(spy, harmonic);
        });
    })
});