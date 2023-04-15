<template>
    <div class="page-content">
        <div class="container-fluid">
            <ValidationMessage></ValidationMessage>
            <!-- Start page title -->
            <Breadcrumbs v-if="$route.name !== 'sale.create' || $route.name !== 'admin.dashboard'"></Breadcrumbs>
            <!-- End page title -->
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import Header from "./../../components/backend/Header";
    import LeftMenu from "./../../components/backend/LeftMenu";
    import Footer from "./../../components/backend/Footer";
    import Breadcrumbs from "./../../components/backend/elements/Breadcrumbs";
    import ValidationMessage from "./../../components/backend/elements/ValidationMessage";

    export default {
        components: {
            Breadcrumbs,
            Header,
            LeftMenu,
            Footer,
            ValidationMessage
        },
        data() {
            return {
                isMainLoader: false,
                html: null,
                config: {},
                defaultConfig: null,
            };
        },
        beforeCreate() {
            if (!Admin.id()) {
                Admin.logout();
            }
        }
    };
</script>
<style lang="scss">
    .modal-backdrop {
        background: #131520c9;
    }

    .vdp-datepicker.custom-datepicker input {
        display: block;
        width: 100%;
        border: 0px;

        &:focus {
            outline: 0;
        }
    }

    .vdp-datepicker__calendar {
        left: 0px;
        box-shadow: 0px 4px 4px #4444;
    }

    .has-error span.help-block {
        color: #fa5c7c;
    }

    label.control-label:after {
        content: '*';
        color: #fa5c7c;
        left: 3px;
        position: relative;
        font-size: 15px;
    }

    .form-group {
        margin-bottom: 10px;
        min-height: 60px;

        &.has-error input {
            border-color: #fa5c7c;

            &:after {
                content: "\f05d6";
                color: #fa5c7c;
                font-family: 'Material Design Icons';
            }
        }

        &.has-success input {
            border-color: #0acf97;

            &:after {
                content: "\f012c";
                color: #0acf97;
                font-family: 'Material Design Icons';
            }
        }

    }

    .vs--searchable .vs__dropdown-toggle {
        width: 100%;
        padding: 0.27rem 0.3rem;
        font-size: 0.8125rem;
        font-weight: 400;
        line-height: 1.5;
        color: var(--vz-body-color);
        background-color: var(--vz-input-bg);
        background-clip: padding-box;
        border: 1px solid var(--vz-input-border);
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 0.25rem;
    }

    .vs__selected-options {
        input {
            border: 0 !important;
        }
    }

    fieldset {
        border: 1px solid #0acf97;
        padding: 28px 20px;
        position: relative;
        margin-top: 30px;
        border-radius: 5px;

        legend {
            border: 1px solid #0acf97;
            position: absolute;
            top: -20px;
            left: 25px;
            width: 20%;
            padding: 0px 14px;
            font-size: 21px;
            background: #fff;
            border-radius: 5px;
        }
    }

    tbody, td, tfoot, th, thead, tr {
        vertical-align: middle;
    }

    .text-red {
        color: #fa5c7c;
    }

    .has-error .vdp-datepicker {
        border-color: #fa5c7c;
    }

    .has-success .vdp-datepicker {
        border-color: #0acf97;
    }

    .custom-control.custom-radio {
        label.custom-control-label {
            margin: 0px 4px;
        }
    }

    a.side-nav-link.active.router-link-active {
        color: #44deed;
    }

    label.custom-file-label {
        display: none;
    }
</style>
