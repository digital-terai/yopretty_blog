<script>
    export default {
        name: 'modal',
        methods: {
            close() {
                alert('close');
                this.$emit('close');
            },
            update : function () {
                alert('ssss');
               this.$emit('update');
            },
            deleteItem : function () {
                alert('delete')
                this.$emit('deleteItem');
            },

        },

        template: require('../template/modal.html'),
    };
</script>


