export default {

    data: () => ({
        path: '',
    }),

    methods: {

        urlHandler(page) {
            if (! page) {
                let query = location.search.match(/page=(\d+)/);
                page = query ? query[1] : 1;
            }
            if(location.href.indexOf("tag") > -1) {
                let tag =this.getTag();
                this.path = `/news/tags/${tag}`;
            }
            else   this.path = `/news`;

            if(page>1){
                this.path+=`?page=${page}`;
            }

            return this.path;
        }
    }

}
