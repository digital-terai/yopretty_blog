<script>
    import {HTTP} from '../mixins/http-common';
    import helper     from '../mixins/helper';
    export default {
        data: () => ({
            socialElements: []
        }),
        mixins: [helper],

        template: require('../template/social-list.html'),
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
               return `/social?limit=4`;
            },
            refresh({data}) {
                this.socialElements = data.data.data
            },

        }
    }
</script>
