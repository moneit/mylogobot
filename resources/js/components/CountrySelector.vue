<template>
    <div class="form-group">
        <div class="input-group">
            <div class="dropdown-menu" :class="{'show': showDropdownMenu}">
                <div class="list-group-item" v-for="country in filteredCountries" :key="country.code" @click.stop="select(country)">
                    {{ country.name }}
                </div>
            </div>
            <div class="dropdown-search" @click.stop>
                <input id="country"
                       class="input-theme"
                       :class="{'is-invalid': invalid, 'has-value': input}"
                       name="country"
                       required
                       @focus="toggle(true, 'input')"
                       v-model="input"
                       tabindex="1"
                       placeholder="Select your country"
                       autocomplete="off">
                <label for="country">Select your country</label>
                <input type="hidden"
                       :value="countryCode"
                       data-vat="country">
            </div>
            <div class="dropdown-toggler input-group-append" :class="{'is-invalid': invalid}" @click.stop="toggle">
                <div class="input-group-text logobot-icon icon-angle-down"></div>
            </div>
        </div>
        <div class="invalid-feedback" v-if="invalid">
            {{ error }}
        </div>
    </div>
</template>

<script>
    import countriesApi from '../services/api/countries.js';

    export default {
        name: "CountrySelector",
        props: ["error", "value", "code"],
        data() {
            return {
                input: this.value,
                showDropdownMenu: false,
                countries: [],
                lastToggleBySecond: 0,
                lastToggleActionSource: null,
                countryCode: this.code
            }
        },
        methods: {
            select(country) {
                this.input = country.name;
                this.countryCode = country.code;
                this.$emit('input', this.input);
                this.$emit('update-code', this.countryCode);

                this.showDropdownMenu = false;
            },
            checkSelect() {
                let filtered = this.countries.filter(country => country.name === this.input);
                if (filtered.length === 1) {
                    this.select(filtered[0]);
                }
            },
            toggle(set = null, src = "btn") { // todo: refactor this whole component to have functionality for tabindex
                let nowBySecond = Math.floor(Date.now() / 1000);

                if (this.lastToggleActionSource === "input"
                    && this.showDropdownMenu === false
                    && src === "btn"
                    && nowBySecond - this.lastToggleBySecond === 0) {
                    this.lastToggleActionSource = src;
                    return;
                }

                if (typeof set === "boolean")
                    this.showDropdownMenu = set;
                else
                    this.showDropdownMenu = !this.showDropdownMenu;

                this.lastToggleBySecond = nowBySecond;
                this.lastToggleActionSource = src;
            },
            hideDropdown() {
                this.toggle(false, "btn");
            },
            onBlur() {
                this.$nextTick(this.toggle(false, "input"));
            }
        },
        computed: {
            filteredCountries() {
                if (this.input) {
                    return this.countries.filter((country) => {
                        return country.name.toLowerCase().includes(this.input.toLowerCase());
                    });
                } else {
                    return this.countries;
                }
            },
            invalid() {
                return this.error && this.input === this.value;
            }
        },
        watch: {
            value(value) {
                this.input = value;
            },
            code(value) {
                this.countryCode = value;
            },
            input() {
                this.checkSelect();
            }
        },
        created() {
            if (!Date.now) {
                Date.now = function() { return new Date().getTime(); }
            }
        },
        mounted() {
            document.addEventListener("click", this.hideDropdown.bind(this));
            countriesApi.get({})
                .then((response) => {
                    this.countries = response;
                });
        },
        beforeDestroy() {
            document.removeEventListener("click", this.hideDropdown);
        }
    }
</script>

<style scoped lang="scss">
    input {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    input::placeholder {
        color: transparent !important;
    }

    input:not(:placeholder-shown) {
        padding: 1.25rem 1.5rem 0.25rem;
    }

    label {
        position: absolute;
        top: 0;
        left: 0;
        margin: 0;
        padding: 0.75rem 1.5rem;
        color: #aaa;
        border: 1px solid transparent;
        pointer-events: none;
        transition: 0.2s ease all;
        -moz-transition: 0.2s ease all;
        -webkit-transition: 0.2s ease all;
    }

    input:not(:placeholder-shown) + label {
        font-size: 0.75rem;
        padding-top: 0.25rem
    }

    .dropdown-search {
        flex: 1;
    }

    .dropdown-toggler {
        cursor: pointer;

        .input-group-text {
            border-left: none;
            border-color: #e9ecef;
            padding-left: 1.25rem;
            padding-right: 1.25rem;
        }

        &.is-invalid {
            .input-group-text {
                border-top-right-radius: 0.25rem;
                border-bottom-right-radius: 0.25rem;
                border-top: 1px solid #dc3545;
                border-right: 1px solid #dc3545;
                border-bottom: 1px solid #dc3545;
            }
        }
    }

    .dropdown-menu {
        right: 0;
        padding: 0;
        max-height: 290px;
        overflow-y: auto;
        margin-top: 0;
    }

    .list-group-item {
        cursor: pointer;
    }

    .list-group-item:hover {
        color: white;
        background-color: #3E3FA0;
    }

    .dropdown-menu.show ~ .dropdown-search input {
        border-color: #3E3FA0;
        /*border-left-color: #3E3FA0;*/
        /*border-left-color: #3E3FA0;*/
    }

    .dropdown-menu.show ~ .dropdown-toggler .input-group-text {
        background-color: #3E3FA0;
        border-color: #3E3FA0;
        color: white;
        /*border-left-color: #3E3FA0;*/
        /*border-left-color: #3E3FA0;*/
    }

    .invalid-feedback {
        display: block;
    }

    .is-invalid {
        border-color: #dc3545;
    }

    /* Fallback for Edge */
    @supports (-ms-ime-align: auto) {
        label {
            display: none;
        }
        input::-ms-input-placeholder {
            color: #777;
        }
    }

    /* Fallback for IE */
    @media all and (-ms-high-contrast: none), (-ms-high-contrast: active) {
        label {
            display: none;
        }
        input:-ms-input-placeholder {
            color: #777;
        }
    }
</style>