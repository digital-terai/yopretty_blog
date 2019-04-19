<script>

    import {HTTP} from '../mixins/http-common';
    import helper     from '../mixins/helper';
    export default {
        data: () => ({
            topicElements: []
        }),
        mixins: [helper],

        template: require('../template/topics-sidebar.html'),
        // Fetches posts when the component is created.
        created() {
            this.fetchData();
        },
        computed: {
            sortedTags: function() {
                function compare(a, b) {
                    if (a.title < b.title)
                        return -1;
                    if (a.title > b.title)
                        return 1;
                    return 0;
                }

                return this.topicElements.sort(compare);
            }
        },
        filters: {
            pinoFilter(value) {
                return value;
            }
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
               return `/tag?limit=100`;
            },
            refresh({data}) {
                this.topicElements = data.data.data
                this.topicElements.sort()
            },

        }
    }
</script>
