Vue.component("information-box", {
    props: ["list", "colors"],
    template: `
    <div class="row">
        <div v-for="(item, index) in list" class="col-md-6">
            <div :class="'small-box '+colors[index]">
                <div class="inner">
                    <h3><u>{{index}}</u></h3>
                    <p>Asignadas: {{item.asignadas}}</p>
                    <p>Completas: {{item.completas}}</p>
                    <p>Respuesta: {{item.respuesta}} %</p>
                </div>
                <div class="icon">
                    <i class="fas fa-adjust"></i>
                </div>
                <!--<a href="#" class="small-box-footer">
                    Más información
                    <i class="fa fa-arrow-circle-right"></i>
                </a>-->
            </div>
        </div>
    </div>
    `
})

Vue.component("information-box-general", {
    props: ["list", "color"],
    template: `
    <div class="row">
        <div v-for="(item, index) in list" class="col-xs-6 col-sm-6 col-md-3">
            <div :class="'small-box '+color">
                <div class="inner">
                    <h4>{{ index.toUpperCase() }}</h4>
                    <p v-if="index == 'respuesta'">{{ item }} %</p>
                    <p v-else>{{ item }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-adjust"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Más información
                    <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    `
})

Vue.component("info-box-small", {
    props: ["list", "icons"],
    template: `
    <div class="row">
        <div v-for="(item, index) in list" class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green">
                    <i :class="icons[item.estado]"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">{{item.estado}}</span>
                    <span class="info-box-number">{{item.total}}</span>
                    <span v-if="item.estado != 'TOTAL DE ENTREVISTAS'" class="info-box-text">{{item.porcentaje_respuesta}} %</span>
                </div>
            </div>
        </div>
    </div>
    `
})