<script>
    import {HTTP} from '../mixins/http-common';
    import helper     from '../mixins/helper';
    export default {
        data: () => ({
            sideElements: []
        }),
        mixins: [helper],

        template: require('../template/blog-sidebar.html'),
        // Fetches posts when the component is created.
        created() {
            this.fetchData();
        },
        methods: {
            fetchData: function () {
               var self = this;
               return HTTP.get(this.url())
                    .then(this.refresh)
                    .catch(e => {
                        self.errors.push(e)
                        self.showMessage(e.message,self.ERROR_CLASS);
                    })
            },
            url() {
               return `/news?limit=6`;
            },
            refresh({data}) {
                this.sideElements = data.data.data
            },

        }
    }
</script>
