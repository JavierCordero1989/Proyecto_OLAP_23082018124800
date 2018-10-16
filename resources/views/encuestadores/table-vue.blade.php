<section class="content">
        
    <div class="row" id="app">
        <caja_usuario v-for="user in listaFiltrada" :user="user"></caja_usuario>
    </div>

    <template id="caja_usuario">
        <div class="col-xs-6">
            <div class="box box-primary collapsed-box">
                <div class="box-header with-border">
                <h3 class="box-title">
                    <span>@{{user.user_code}}</span> @{{user.name}}
                </h3>
                
                <div class="box-tools pull-right">
                    <div class='btn-group'>
                        <button type="button" class="btn btn-info btn-xs" data-widget="collapse">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                
                </div>
                
                <div class="box-body">
                    <div class="col-md-12">
                        <img class="card-img-top" data-src="https://i0.wp.com/blogthinkbig.com/wp-content/uploads/2017/02/code-html-digital-coding-web.jpg?resize=610%2C342" alt="imagen" style="height: 100%; width: 100%; display: block;" src="https://i0.wp.com/blogthinkbig.com/wp-content/uploads/2017/02/code-html-digital-coding-web.jpg?resize=610%2C342" data-holder-rendered="true">
                    </div>
                </div>
                
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-5 col-xs-offset-1">
                            <a href="#" class="btn btn-primary btn-sm col-sm-12">
                                <i class="fa fa-plus-square"></i> Asignar Encuestas
                            </a>
                        </div>
                        
                        <div class="col-xs-5">
                            <a href="#" class="btn btn-primary btn-sm col-sm-12">
                                <i class="far fa-eye"></i> Encuestas asignadas
                            </a>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </template>
</section>

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js"></script>
    <script>
        Vue.component('caja_usuario',{
            template: '#caja_usuario',
            props: {
                user: {
                    type: Object,
                    required: true
                }
            }
        })

        new Vue({
            el: '#app',
            data:{
                text: '',
                list: <?php echo $lista_encuestadores; ?>
            },
            computed: {
                listaFiltrada(){
                    return this.list.filter(element => {
                        let result = false
                        result = result || element.user_code.toLowerCase().includes(this.text.toLowerCase())
                        result = result || element.name.toLowerCase().includes(this.text.toLowerCase())
                        return result
                    })
                }
            }
        })
    </script>
@endsection