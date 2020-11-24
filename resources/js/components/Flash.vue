<template>
    <div
        :class="{
            'alert-danger': type === 'error',
            'alert-success': type === 'success',
            'alert-warning': type === 'warning',
            'alert-info': type === 'info',
         }"
        class="alert alert-block fade show"
        v-show="show"
    >
        <button type="button" class="close" @click.stop="hide">×</button>
        {{ body }}
    </div>
</template>

<script>
export default {
    props: ['message'],
    data() {
        return {
            type: '',
            show: false,
            body: '',
        }
    },
    created() {
        if(this.message && this.message.text && this.message.type) {
            this.flash(this.message);
        }
        window.events.$on('flash',(message) => this.flash(message));
    },
    methods: {
        flash(message) {
            this.show = true;
            this.body = message.text;
            this.type = message.type;

            if (message.timer) {
                setTimeout(() => {
                    this.hide()
                }, message.timer);
            }
        },
        hide() {
            this.show = false;
            this.reset();
        },
        reset() {
            this.type = '';
            this.body = '';
        }
    }
}
</script>
