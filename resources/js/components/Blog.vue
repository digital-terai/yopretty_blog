<script>
    import {HTTP} from '../mixins/http-common';
    import collection from '../mixins/collection';
    import helper     from '../mixins/helper';

    export default {
        data: () => ({
            dataSet: {},
            loading: false,
        }),
        mixins: [collection,helper],

        template: require('../template/blog-list.html'),
        // Fetches posts when the component is created.
        created() {
            this.fetchData();
        },
        methods: {
            fetchData: function (page) {
                var self = this;
               return HTTP.get(this.url(page))
                    .then(this.refresh)
                    .then(
                        //self.showMessage('caricato.....'+page,self.SUCCESS_CLASS)
                    )
                    .catch(e => {
                        self.errors.push(e)
                        self.showMessage(e.message,self.ERROR_CLASS);

                    })
            },
            url(page) {
               return this.urlHandler(page);
            },
            refresh({data}) {
                this.items = data.data.data
                this.dataSet = data.data;
                window.scrollTo(0, 0);
            },
            getTag(){
               return location.href.substr(location.href.lastIndexOf('/') + 1);
            },
        }
    }
</script>
