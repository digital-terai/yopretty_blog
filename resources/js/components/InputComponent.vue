<script>
    import collection from '../mixins/collection';
    export default {
        props: ['model', 'name', 'item_id','type'],
        data: function () {
            return {
                message: ''
            }
        },
        mixins: [collection],

        methods: {
            inputHandler: function () {
                let url = window.urlAjaxHandlerCms + 'update/updateItemField/' + this.model + '/' + this.item_id;
                axios.get(url,
                    {
                        params:{
                            field: this.name,
                            value: this.message
                        }
                    }
                )
                .then(response => this.simpleAjaxResponse(response))
                .catch(error => this.responseWithError(error));
            }
        },
        template: '<input v-model="message" type="text" v-on:change.prevent="inputHandler"/>'
    }
</script>
