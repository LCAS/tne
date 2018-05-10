<template>
<div id="column is-three-fifths is-offset-one-fifth">
    <div v-if="countries.length || country_loading" class="field control has-icons-left">
        <div class="select is-fullwidth is-primary is-medium">
            <select
                tabindex="1"
                v-model="country"
                name="country"
                class="fixedwidth"
                :disabled="country_loading == 1">
                <option value=""> --- Select Country --- </option>
                <option v-for="country in countries"
                    :value="country.id"
                    :selected="country.selected == true">
                    {{ country.name }}
                </option>
            </select>
        </div>
        <span class="icon is-medium is-left">
            <i  v-if="country_loading" class="fa fa-spinner fa-spin"></i>
            <i v-else class="fa fa-globe"></i>
        </span>
    </div>
    <div v-else class="box is-fullwidth">
        <p class="button is-white is-fullwidth">
            The system is still being setup
        </p>
    </div>

    <div v-if="country" class="field control has-icons-left">
        <div v-if="programmes.length || programme_loading">
            <div class="select is-fullwidth is-primary is-medium">
                <select
                    tabindex="2"
                    v-model="programme"
                    name="programme"
                    class="fixedwidth"
                    :disabled="programme_loading == 1">
                    <option value=""> --- Select Programme --- </option>
                    <option v-for="programme in programmes"
                        :value="programme.id"
                        :selected="programme.selected == true">
                        {{ programme.name }}
                    </option>
                </select>
            </div>
            <span class="icon is-medium is-left">
                <i  v-if="programme_loading" class="fa fa-spinner fa-spin"></i>
                <i v-else class="fa fa-book"></i>
            </span>
        </div>
        <div v-else class="box is-fullwidth">
            <p class="button is-white is-fullwidth">
                This country has no programmes
            </p>
        </div>
    </div>

    <div v-if="programme" class="field control has-icons-left">
        <div v-if="modules.length || module_loading">
            <div class="select is-fullwidth is-primary is-medium">
                <select
                    tabindex="3"
                    v-model="module"
                    name="module"
                    class="fixedwidth"
                    :disabled="module_loading == 1">
                    <option value=""> --- Select Module --- </option>
                    <option v-for="module in modules"
                        :value="module.id"
                        :selected="module.selected == true">
                        {{ module.name }}
                    </option>
                </select>
            </div>
            <span class="icon is-medium is-left">
                <i  v-if="module_loading" class="fa fa-spinner fa-spin"></i>
                <i v-else class="fa fa-file-text-o"></i>
            </span>
        </div>
        <div v-else class="box is-fullwidth">
            <p class="button is-white is-fullwidth">
                This programme has no modules
            </p>
        </div>
    </div>
</div>
</template>
<script>
    export default {
        data() {
            return {
                countries: [],
                country: "",
                country_loading: true,
                programmes: [],
                programme: "",
                programme_loading: true,
                modules: [],
                module: "",
                module_loading: true,
                error: (error) => {
                    flash("Opps! Something went wrong!", 'error');
                    this.country_loading = false;
                }
            }
        },
        created() {
            axios.get(window.tne_base_path + '/countries')
                .then((response) => {
                    this.countries = response.data;
                    this.country_loading = false;
                }).catch(this.error);
        },
        watch: {
            country: function(val) {
                this.programme = "";
                this.module = "";
                this.programmes = [];
                this.modules = [];
                if (val != "") {
                    this.programme_loading = true;
                    axios.get(window.tne_base_path + '/programmes/' + val)
                        .then((response) => {
                            this.programmes = response.data;
                            this.programme_loading = false;
                        }).catch(this.error);
                }
            },
            programme: function(val) {
                this.module = "";
                this.modules = [];
                if (val != "") {
                    this.module_loading = true;
                    axios.get(window.tne_base_path + '/modules/' + val)
                        .then((response) => {
                            this.modules = response.data;
                            this.module_loading = false;
                        }).catch(this.error);
                }
            },
            module: function(val) {
                this.$emit('updatetable', this.module);
            },
        }
    }
</script>
<style lang="scss">
    .fixedwidth { align-items: stretch; }
</style>