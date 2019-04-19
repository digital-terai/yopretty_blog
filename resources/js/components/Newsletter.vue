<template>
<span id="form-newsletters" name="form-newsletter" class="form-inline">
    <label class="big">Newsletter </label>
    <div class="input-group">
        <div id="app"></div>
        <input v-model="email" class="form-control"
               type="text"
               id="email"
               name="email"
               placeholder=" Type you email ">

        <div class="input-group-btn">
            <button id=""
                    class="btn btn-newsletter btn-full"
                    type="button"
                    @click.prevent="sendSubscribe"

            >Send </button>
        </div>
    </div>
</span>
</template>

<script>
    import {HTTP} from '../mixins/http-common';
    import collection from '../mixins/collection';
    export default {
        mounted() {
            console.log('Component mounted.newsletter')
        },
        data() {
            return {
               email: ''
            };
        },
        mixins: [collection],
        methods: {
            sendSubscribe() {
               if(this.email=='')flash('Invalid Email',this.ERROR_CLASS);
               else axios.post('/api/newsletter', {email: this.email })
                    .then(({data}) => {
                        if(data.status=='ok'){
                            this.cleaInput();
                            flash(data.msg,this.SUCCESS_CLASS);
                            this.$emit('created', data);
                        }
                        else {
                            flash(data.errors.email,this.ERROR_CLASS);
                        }

                    });
            },
            cleaInput(){
                this.email=''
            },
        }
    }
</script>
