Vue.mixin({
    methods: {
        // =================  get single data =================
        get_data(url, dataVar, slug = null, spin = true) {
            try {
                (spin) ? this.$root.spinner = true : '';

                let path = (slug) ? url + "/" + slug : url
                axios.get("/" + path)
                    .then(res => this.data[dataVar] = res.data)
                    .catch(error => console.log(error))
                    .then(alw => setTimeout(() => (this.$root.spinner = false), 200));
            } catch (e) {
                return e.response;
            }
        },
        // =================  get single data =================
        get_options(url, state) {
            try {
                this.$root.spinner = true;
                axios.get(url)
                    .then(res => {
                        this.options[state] = res.data
                    })
                    .catch(error => console.log(error))
                    .then(alw => setTimeout(() => (this.$root.spinner = false), 200));
            } catch (e) {
                return e.response;
            }
        },

        // =================  get paginate data =================
        get_paginate_data(url, params = null) {
            try {
                this.$root.spinner = true;
                axios
                    .get(url, { params: params })
                    .then(res => {
                        this.table['datas'] = res.data.data;
                        this.table['meta'] = res.data.meta;
                        this.table['links'] = res.data.links;
                    })
                    .catch(error => console.log(error))
                    .then(alw => setTimeout(() => (this.$root.spinner = false), 200));
            } catch (e) {
                return e.response;
            }
        },
    }
});
