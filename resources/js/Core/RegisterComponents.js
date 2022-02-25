// import components
import {
    MDBBadge,
    MDBBtn,
    MDBBtnClose,
    MDBBtnGroup,
    MDBCard,
    MDBCardBody,
    MDBCardFooter,
    MDBCardHeader,
    MDBCardImg,
    MDBCardText,
    MDBCardTitle,
    MDBCol,
    MDBCollapse,
    MDBContainer,
    MDBDropdown,
    MDBDropdownItem,
    MDBDropdownMenu,
    MDBDropdownToggle,
    MDBFooter,
    MDBIcon,
    MDBInput,
    MDBModal,
    MDBModalBody,
    MDBModalFooter,
    MDBModalHeader,
    MDBModalTitle,
    MDBNavbar,
    MDBNavbarBrand,
    MDBNavbarItem,
    MDBNavbarNav,
    MDBRow,
    MDBSwitch,
    MDBTabContent,
    MDBTabItem,
    MDBTable,
    MDBTabNav,
    MDBTabPane,
    MDBTabs,
    MDBCheckbox,
} from 'mdb-vue-ui-kit';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Head } from '@inertiajs/inertia-vue3';
import Guest from '@/Layouts/Guest.vue';
import Authenticated from '@/Layouts/Authenticated.vue';
import { InertiaLink } from '@inertiajs/inertia-vue3/src';
import CustomLink from '@/Layouts/Partials/CustomLink';

// register components
export const RegisterComponents = (app) => {
    app.component('MDBBtnClose', MDBBtnClose)
        .component('MDBCardFooter', MDBCardFooter)
        .component('InertiaLink', InertiaLink)

        .component('FontAwesomeIcon', FontAwesomeIcon)
        // .component('custom-link', customLink)
        .component('MDBInput', MDBInput)
        .component('MDBTabs', MDBTabs)
        .component('MDBSwitch', MDBSwitch)
        .component('MDBTabNav', MDBTabNav)
        .component('MDBTabItem', MDBTabItem)
        .component('MDBTabContent', MDBTabContent)
        .component('MDBTabPane', MDBTabPane)
        .component('guest-layout', Guest)
        .component('authenticated', Authenticated)
        .component('MDBBtnGroup', MDBBtnGroup)
        .component('MDBBadge', MDBBadge)
        .component('MDBFooter', MDBFooter)
        .component('MDBCardHeader', MDBCardHeader)
        .component('MDBIcon', MDBIcon)
        .component('MDBRow', MDBRow)
        .component('MDBCol', MDBCol)
        .component('MDBCardText', MDBCardText)
        .component('MDBCardImg', MDBCardImg)
        .component('MDBCardTitle', MDBCardTitle)
        .component('MDBCardBody', MDBCardBody)
        .component('MDBCard', MDBCard)
        .component('MDBContainer', MDBContainer)
        .component('MDBBtn', MDBBtn)
        .component('MDBNavbar', MDBNavbar)
        .component('MDBNavbarToggler', MDBNavbar)
        .component('MDBNavbarBrand', MDBNavbarBrand)
        .component('MDBNavbarNav', MDBNavbarNav)
        .component('MDBNavbarItem', MDBNavbarItem)
        .component('MDBCollapse', MDBCollapse)
        .component('MDBDropdown', MDBDropdown)
        .component('MDBDropdownToggle', MDBDropdownToggle)
        .component('MDBDropdownMenu', MDBDropdownMenu)
        .component('MDBDropdownItem', MDBDropdownItem)
        .component('MDBCheckbox', MDBCheckbox)

        .component('Head', Head)

        .component('MDBModal', MDBModal)
        .component('MDBModalBody', MDBModalBody)
        .component('MDBModalHeader', MDBModalHeader)
        .component('MDBModalTitle', MDBModalTitle)
        .component('MDBModalFooter', MDBModalFooter)
        .component('MDBTable', MDBTable)
        .component('CustomLink', CustomLink);
};
