<template>
    <div class="modal fade" id="modalConfirm" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form ref="form" id="deleteForm" method="POST" :action="this.config.url">
                <input type="hidden" name="_method" :value="this.config.requestMethod">
                <input type="hidden" name="_token" :value="csrf">
                <input v-if="this.config.email" type="hidden" name="email" :value="this.config.email">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="text-center">{{ this.config.text }} {{this.config.email}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Nie</button>
                        <button type="submit" class="btn btn-success" data-dismiss="modal" @click="submit">Áno</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['config'],
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                postData: {email: this.config.email}
            };
        },
        methods: {
            submit() {
                if (this.config.ajax) {
                    this.$emit('ajaxModalSubmit', this.config.url, this.config.requestMethod, {email: this.config.email});
                } else {
                    this.$refs.form.submit()
                }
            }
        }
    };
</script>
