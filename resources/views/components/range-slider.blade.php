<div {{ $attributes }} x-data="{
    value: @json($value),
    min: {{ $min }},
    max: {{ $max }},
    stepSize: 1,
    minthumb: 0,
    maxthumb: 0,
    draggingThumb: null,
    stepValues: [],
    dispatchValue: null,
    init() {
        this.stepValues = Array.from({ length: Math.floor((this.max - this.min) / this.stepSize) + 1 }, (_, i) => this.min + i * this.stepSize);
        this.mintrigger();
        this.maxtrigger();

        this.dispatchValue = Alpine.debounce(value => this.$dispatch('range-updated', [...value]), 500);
    },
    mintrigger() {
        this.value[0] = Math.min(this.value[0], this.value[1] - this.stepSize);
        this.minthumb = ((this.value[0] - this.min) / (this.max - this.min)) * 100;
    },
    maxtrigger() {
        this.value[1] = Math.max(this.value[1], this.value[0] + this.stepSize);
        this.maxthumb = ((this.value[1] - this.min) / (this.max - this.min)) * 100;
    },
    setMin(value, dispatch = true) {
        if (value <= this.value[1] - this.stepSize) {
            const temp = Math.round(value);
            
            if (temp !== this.value[0]) {
                this.value[0] = temp;
                this.mintrigger();
                if (dispatch) {
                    this.$nextTick(() => this.dispatchValue(this.value));
                }
            }
        }
    },
    setMax(value, dispatch = true) {
        if (value >= this.value[0] + this.stepSize) {
            const temp = Math.round(value);

            if (temp !== this.value[1]) {
                this.value[1] = temp;
                this.maxtrigger();
                if (dispatch) {
                    this.$nextTick(() => this.dispatchValue(this.value));
                }
            }
        }
    },
    onDrag(event) {
        if (this.draggingThumb) {
            let rect = this.$el.getBoundingClientRect();
            let offsetX = event.clientX - rect.left;
            let percentage = (offsetX / rect.width) * 100;
            let newValue = this.min + (percentage / 100) * (this.max - this.min);

            if (this.draggingThumb === 'min') {
                this.setMin(newValue, false); // Don't dispatch during drag
            } else if (this.draggingThumb === 'max') {
                this.setMax(newValue, false); // Don't dispatch during drag
            }
        }
    },
    stopDragging() {
        if (this.draggingThumb) {
            this.$nextTick(() => this.dispatchValue(this.value))
            this.draggingThumb = null;
        }
    },
    startDragging(thumb) {
        this.draggingThumb = thumb;
    },
    handleClick(step) {
        if (Math.abs(step - this.value[0]) < Math.abs(step - this.value[1])) {
            this.setMin(step);
        } else {
            this.setMax(step);
        }
    }
}" class="years-range-wrapper flex justify-center items-center h-[30px]"
   @mousemove="onDrag($event)"
   @mouseup="stopDragging()"
   @mouseleave="stopDragging()"
   @touchmove="onDrag($event)"
   @touchend="stopDragging()"
>
    <div class="relative w-full">
        <div>
            <input class="hidden" type="range" x-bind:step="stepSize" x-bind:min="min" x-bind:max="max" x-model="value[0]" disabled>
            <input class="hidden" type="range" x-bind:step="stepSize" x-bind:min="min" x-bind:max="max" x-model="value[1]" disabled>

            <div class="relative z-10 h-2 mr-4">
                <div class="absolute z-10 left-0 right-0 top-1/2 -translate-y-1/2 rounded-md bg-gray-400 h-1"></div>
                <div class="absolute z-20 top-1/2 -translate-y-1/2 rounded-md bg-gray-800 h-1" x-bind:style="'right:'+ (100 - maxthumb) + '%; left:' + minthumb + '%'"></div>

                <template x-for="(step, index) in stepValues" :key="index">
                    <div class="absolute top-0.5 w-3 h-3 -mt-1 cursor-pointer z-20" :style="'left: calc('+ ((step - min) / (max - min)) * 100 +'%)'"
                        @click="handleClick(step)">
                        <span :class="(step >= value[0] && step <= value[1]) ? 'bg-gray-800' : 'bg-gray-400'"
                            class="w-3 h-3 block rounded-full"></span>
                    </div>
                </template>

                <div class="absolute z-30 w-12 h-8 top-3 flex items-center font-bold justify-center thumbsup bg-gray-800 text-white text-xs rounded-lg -mt-5 cursor-pointer"
                     x-bind:style="'left: calc(' + minthumb + '% - 18px)'"
                     @mousedown.prevent="startDragging('min')" 
                     @touchstart.prevent="startDragging('min')">
                     <span x-text="value[0]" class="pointer-events-none">
                     </span>
                </div>

                <div class="absolute z-30 w-12 h-8 top-3 flex items-center font-bold justify-center thumbsup bg-gray-800 text-white text-xs rounded-lg -mt-5 cursor-pointer"
                     x-bind:style="'left: calc(' + maxthumb + '% - 18px)'"
                     @mousedown.prevent="startDragging('max')" 
                     @touchstart.prevent="startDragging('max')">
                     <span x-text="value[1]" class="pointer-events-none">
                     </span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
  .thumbsup {
      width: 50px;
      height: 25px;
      background-color: #333;
      color: #fff;
      font-size: 12px;
      border-radius: 10px;
      text-align: center;
      line-height: 25px;
  }

  .pointer-events-none {
      pointer-events: none;
  }
</style>
