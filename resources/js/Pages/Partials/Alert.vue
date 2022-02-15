<template>

            <div class="row text-center">
                <div class="col-sm-12">
                    <div class="alert warning fade alert-simple alert-warning show" role="alert">
                        <font-awesome-icon class="start-icon" icon="exclamation-triangle" />
                        <slot name="message"/>
                    </div>
                </div>
            </div>

</template>

<script>
export default {

}
</script>

<style scoped>

.alert>.start-icon {
    margin-right: 5px;
    min-width: 20px;
    text-align: center;
}


.alert-simple.alert-warning
{
    border: 1px solid rgba(241, 142, 6, 0.81);
    background-color: rgba(220, 128, 1, 0.16);
    box-shadow: 0px 0px 2px #ffb103;
    color: #ffb103;
    transition:0.5s;
}

.alert-warning:hover{
    background-color: rgba(220, 128, 1, 0.33);
    transition:0.5s;
}

.warning
{
    font-size: 18px;
    color: #ffb40b;
    text-shadow: none;
}

.alert:before {
    content: '';
    position: absolute;
    width: 0;
    height: calc(100% - 44px);
    border-left: 1px solid;
    border-right: 2px solid;
    border-bottom-right-radius: 3px;
    border-top-right-radius: 3px;
    left: 0;
    top: 50%;
    transform: translate(0,-50%);
    height: 20px;
}







</style>
