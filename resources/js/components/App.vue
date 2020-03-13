<template>
    <div class="container-fluid bg-white">
        <div class="row justify-content-center">
            <div id="graphic" style="min-height: 700px"></div>
            <div style="margin: 15px 0;">
                Filtrar cidadãos:
                <el-checkbox v-model="filters.man">Homens</el-checkbox>
                <el-checkbox v-model="filters.woman">Mulheres</el-checkbox>
            </div>
            <div class="col-12" v-if="citizens.length">

                <CTable :data="citizens" title="Cidadãos de XPTO"></CTable>
                <CTable
                        :data="sick" title="Cidadãos que tiveram dengue"
                        :a="{text:'Cidadãos que tiveram dengue',value:sick.length}"
                        :b="{text:'cidadãos que não tiveram dengue',value:citizens.length-sick.length}"
                        :ab="{text:'Todos',value:citizens.length}"
                        :has-chart="true"
                ></CTable>
                <CTable :data="students" title="Cidadãos que estudaram"></CTable>
                <CTable :data="buss" title="Cidadãos que andam de ônibus"></CTable>
                <CTable :data="sickAndStudent" title="Tiveram dengue e estudaram"></CTable>
                <CTable :data="sickAndBuss" title="Tiveram dengue e andam de ônibus"></CTable>
                <CTable :data="sickAndStudentAndBuss"
                        title="Tiveram dengue, estudaram na cidade e andam de ônibus"></CTable>
                <h1>Exercicios:</h1>

                <CTable
                        title="1 . Relatório Educação: Informar nome, data de nascimento e id dos cidadãos de XPTO que frequentaram a escola, menos os cidadãos que tiveram dengue."
                        :data="studentsNotSick"
                ></CTable>

                <CTable
                        title="2 . Relatório Saúde: Informar nome, data de nascimento e data que tiveram dengue dos cidadãos de XPTO que frequentaram o posto de saúde, menos os cidadãos que não utilizam ônibus."
                        :data="sickNotBuss"
                ></CTable>

                <CTable
                        title="3 . Relatório Mobilidade: Informar nome, data de nascimento e linhas de ônibus dos cidadãos de XPTO que
                        utilizaram o transporte público e não tiveram dengue."
                        :data="bussNotSick"
                        :show_studding="false"
                        :show_gender="false"
                        :show_father_name="false"
                        :show_mother_name="false"
                        :show_disease_date="false"
                ></CTable>

                <CTable
                        title="4 . Relatório Educação e Saúde: Informar nome, data de nascimento, id e data que tiveram dengue dos cidadãos de XPTO que
                        frequentaram a escola e tiveram dengue."
                        :data="sickIsStudentAndSick"
                ></CTable>

                <CTable
                        title="5 . Relatório Educação e Mobilidade: Informar nome, data de nascimento, id e linhas de ônibus dos cidadãos de XPTO que
                        frequentaram a escola e utilizaram transporte público."
                        :data="studentsUsedBuss"
                ></CTable>

                <CTable
                        title="6 . Relatório Saúde e Mobilidade: Informar nome, data de nascimento, data que tiveram dengue e linhas de ônibus dos cidadãos de XPTO que
                        frequentaram o posto de saúde e utilizaram transporte público."
                        :data="sickUsedBuss"
                ></CTable>

                <CTable
                        title="7 . Relatório Saúde, Mobilidade e Educação: Informar nome, data de nascimento, data que tiveram dengue e linhas de ônibus  dos cidadãos de XPTO que
                        frequentaram o posto de saúde, utilizaram transporte público e frequentaram a escola."
                        :data="sickUsedBussAndStudent"
                ></CTable>

                <CTable
                        title="8 . Informar nome, data de nascimento, data que tiveram dengue dos cidadãos de XPTO que
                        frequentaram o posto de saúde, mas não utilizaram transporte público."
                        :data="sickNotUsedBuss"
                ></CTable>

                <CTable
                        title="9 . Informar nome, data de nascimento, data que tiveram dengue dos cidadãos de XPTO que
                        frequentaram o posto de saúde, mas não frequentaram a escola."
                        :data="sickNotStudent"
                ></CTable>

                <CTable
                        title="10 . Informar nome, data de nascimento, data que tiveram dengue dos cidadãos de XPTO que
                        frequentaram o posto de saúde, mas não frequentaram a escola, nem utilizaram transporte público."
                        :data="sickNotStudentNotBuss"
                ></CTable>

            </div>
        </div>
    </div>
</template>

<script>

    import CTable from "./CTable";

    export default {
        components: {
            CTable,
        },
        data() {
            return {
                citizen_list: [],
                filters: {
                    man: false,
                    woman: false,
                }
            }
        },
        mounted() {
            this.getCitizens().then(r => {
                this.mountGraphic();
            })
        },
        methods: {
            mountGraphic() {
                setTimeout(() => {
                    Highcharts.chart('graphic', {
                        series: [{
                            type: 'venn',
                            data: [{
                                name: 'Tiveram dengue',
                                sets: ['A'],
                                value: this.sick.length,
                            }, {
                                name: 'Estudaram',
                                sets: ['B'],
                                value: this.students.length
                            }, {
                                name: 'Andam de onibus',
                                sets: ['C'],
                                value: this.buss.length
                            },
                                {
                                    name: 'Tiveram dengue e estudaram',
                                    sets: ['A', 'B'],
                                    value: this.sickAndStudent.length
                                },
                                {
                                    name: 'Tiveram dengue e andam de onibus',
                                    sets: ['A', 'C'],
                                    value: this.sickAndBuss.length
                                },
                                {
                                    name: 'Estudaram e andam de onibus',
                                    sets: ['B', 'C'],
                                    value: this.studentAndBuss.length
                                }, {
                                    name: 'Estudaram, tiveram dengue e andam de coletivo',
                                    sets: ['A', 'B', 'C'],
                                    value: this.sickAndStudentAndBuss.length
                                },
                            ]
                        }],
                        title: {
                            text: 'DIAGRAMA GERAL'
                        }
                    });

                }, 2000);
            },
            getCitizens() {
                return axios.get('/citizen').then(r => {
                    this.citizen_list = r.data.data;
                    this.mountGraphic();
                });
            },
        },
        computed: {
            citizens() {

                let list = this.citizen_list;

                if (this.filters.man) {
                    list = this.citizens_man;
                }

                if (this.filters.woman) {
                    list = this.citizens_woman;
                }

                return list;

            },
            citizens_man() {
                return this.citizen_list.filter(c => c.gender === 'm')
            },
            citizens_woman() {
                return this.citizen_list.filter(c => c.gender === 'f')
            },
            /*A*/
            sick() {
                return this.citizens.filter(c => !!c.disease_date)
            },
            /*B*/
            students() {
                return this.citizens.filter(c => !!c.studding);
            },
            /*C*/
            buss() {
                return this.citizens.filter(c => !!c.buss)
            },
            /*AB*/
            sickAndStudent() {
                return this.citizens.filter(c => c.studding && c.disease_date)
            },
            /*AC*/
            sickAndBuss() {
                return this.citizens.filter(c => !!c.disease_date && !!c.buss)
            },
            /*BC*/
            studentAndBuss() {
                return this.citizens.filter(c => !!c.studding && !!c.buss)
            },
            /*ABC*/
            sickAndStudentAndBuss() {
                return this.citizens.filter(c => !!c.studding && !!c.buss && !!c.disease_date)
            },


            /*QUESTÕES*/
            /* 1 . Relatório Educação: Informar nome, data de nascimento e id dos cidadãos de XPTO
            que frequentaram a escola, menos os cidadãos que tiveram dengue.*/
            studentsNotSick() {
                return this.students.filter(s => !s.disease_date);
            },
            /*2 . Relatório Saúde: Informar nome, data de nascimento e data que tiveram dengue dos cidadãos de XPTO
            que frequentaram o posto de saúde, menos os cidadãos que não utilizam ônibus. */
            sickNotBuss() {
                return this.sick.filter(s => !s.buss);
            },
            /*3 . Relatório Mobilidade: Informar nome, data de nascimento e linhas de ônibus dos cidadãos de XPTO
            que utilizaram o transporte público e não tiveram dengue.*/
            bussNotSick() {
                return this.buss.filter(s => !s.disease_date);
            },
            /*4 . Relatório Educação e Saúde: Informar nome, data de nascimento, id e data que tiveram dengue dos cidadãos de XPTO
            que frequentaram a escola e tiveram dengue.*/
            sickIsStudentAndSick() {
                return this.sick
                    .filter(s => !!s.studding)
                    .filter(s => !!s.disease_date);
            },
            /*5 . Relatório Educação e Mobilidade: Informar nome, data de nascimento, id e linhas de ônibus dos cidadãos de XPTO
            que frequentaram a escola e utilizaram transporte público.*/
            studentsUsedBuss() {
                return this.students.filter(s => !!s.buss)
            },
            /*6 . Relatório Saúde e Mobilidade: Informar nome, data de nascimento, data que tiveram dengue e linhas de ônibus dos cidadãos de XPTO
            que frequentaram o posto de saúde e utilizaram transporte público.*/
            sickUsedBuss() {
                return this.sick.filter(s => !!s.buss)
            },
            /*7 . Relatório Saúde, Mobilidade e Educação: Informar nome, data de nascimento, data que tiveram dengue e linhas de ônibus  dos cidadãos de XPTO que
                        frequentaram o posto de saúde, utilizaram transporte público e frequentaram a escola.*/
            sickUsedBussAndStudent() {
                return this.sick.filter(s => !!s.buss)
                    .filter(s => !!s.buss)
                    .filter(s => !!s.studding);
            },
            /*8 . Informar nome, data de nascimento, data que tiveram dengue dos cidadãos de XPTO que
                        frequentaram o posto de saúde, mas não utilizaram transporte público.*/
            sickNotUsedBuss() {
                return this.sick.filter(s => !s.buss)
            },
            /*9 . Informar nome, data de nascimento, data que tiveram dengue dos cidadãos de XPTO que
            frequentaram o posto de saúde, mas não frequentaram a escola.*/
            sickNotStudent() {
                return this.sick.filter(s => !s.studding)
            },
            /*10) Informar nome, data de nascimento, data que tiveram dengue dos cidadãos de XPTO
            que frequentaram o posto de saúde, mas não frequentaram a escola, nem utilizaram transporte público.*/
            sickNotStudentNotBuss() {
                return this.sickNotStudent.filter(s => !s.buss)
            }
        },
        watch: {
            filters: {
                deep: true,
                handler: function () {
                    this.mountGraphic()
                }
            }
        }
    }
</script>
<style lang="scss">
    @import '~element-ui/lib/theme-chalk/index.css';
</style>
