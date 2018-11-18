Vue.component("information-box", {
    props: ["list"],
    template: `
    <div class="row">
        <div v-for="item in list" class="col-xs-6 col-sm-6 col-md-3">
            <div :class="'small-box '+item.color">
                <div class="inner">
                    <h3>{{item.title}}</h3>
                    <p>{{item.text}}</p>
                </div>
                <div class="icon">
                    <i :class="item.icon"></i>
                </div>
                <a :href="item.link" class="small-box-footer">
                    Más información
                    <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    `
})

Vue.component("info-box-small", {
    props: ["list"],
    template: `
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span :class="'info-box-icon '+item.color">
                    <i :class="item.icon"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">{{item.text}}</span>
                    <span class="info-box-number">{{item.data}}</span>
                    <span class="info-box-text">{{item.percent}}</span>
                </div>
            </div>
        </div>
    </div>
    `
})