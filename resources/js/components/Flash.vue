<template>
    <div :class="classes"
         role="alert" v-show="show">
         <i :class="iconClasses"></i> <strong>{{ body }}</strong>
    </div>
</template>

<script>
    export default {
        props: ['message','status'],
        data() {
            return {
                body: '',
                statusClass : 'alert-success',
                iconClass   : 'fa-smile-o',
                show: false
            }
        },
        computed: {
            classes() {
                return ['alert  alert-flash ' +this.statusClass];
            },
            iconClasses() {
                return ['fa fa-2x ' +this.iconClass];
            }

        },
        created() {

            if (this.message) {
                this.flash(this.message,this.status);
            }
            window.events.$on(
              'flash', (message,status) => this.flash(message,status)
            );
        },
        methods: {
            flash(message,status='success') {
                this.body = message;
                this.setStatus(status);
                this.setIconStatus()
                this.show = true;
                this.hide();
            },
            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            },
            setStatus(status) {
               this.statusClass = 'alert-'+status;
            },
            setIconStatus() {
                this.iconClass = (this.statusClass=='alert-success')? 'fa-smile-o' : 'fa-frown-o' ;
            }
        }
    };
</script>
<style>
    .alert-flash {
        position: fixed;
        left: 25px;
        bottom: 125px;
        z-index: 10000;
        font-size:1.3rem;
        line-height: 1.5rem;
        vertical-align: middle;
    }
    @media screen and (max-width: 767px) {
        .alert-flash {
            position: fixed;
            left: 15px;
            bottom: 175px;
            width:95%;

        }
    }
</style>