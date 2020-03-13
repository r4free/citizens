<template>
    <div>
        <div id="teste" v-show="graphic" v-if="hasChart"></div>
        <el-collapse accordion>
            <el-collapse-item name="1">
                <template slot="title">
                    <span class="ml-2">{{title}}</span>
                    <el-tag type="success">{{data.length}}</el-tag>
                </template>

                <div style="margin: 15px 0;">
                    Filtrar exibição dos campos:
                    <el-checkbox v-model="graphic" v-if="hasChart">Gráfico</el-checkbox>
                    <el-checkbox v-model="fields.index">Ordem</el-checkbox>
                    <el-checkbox v-model="fields.name">ID</el-checkbox>
                    <el-checkbox v-model="fields.name">Nome</el-checkbox>
                    <el-checkbox v-model="fields.father_name">Nome do pai</el-checkbox>
                    <el-checkbox v-model="fields.mother_name">Nome da mãe</el-checkbox>
                    <el-checkbox v-model="fields.gender">Sexo</el-checkbox>
                    <el-checkbox v-model="fields.studding">Estudaram</el-checkbox>
                    <el-checkbox v-model="fields.buss">Linhas de ônibus</el-checkbox>
                    <el-checkbox v-model="fields.disease_date">Data da dengue</el-checkbox>
                    <el-checkbox v-model="fields.birthday">Data de nascimento</el-checkbox>
                </div>
                <download-excel
                        :data   = "data"
                type="csv">
                    Download Excel
                </download-excel>
                <el-table :data="data" border style="width: 100%" class="ml-2">
                    <el-table-column type="index" width="50"></el-table-column>
                    <el-table-column
                            v-if="fields.id && show_id"
                            prop="id"
                            label="ID"
                            width="50"
                            sortable
                    ></el-table-column>
                    <el-table-column
                            v-if="fields.name && show_name"
                            prop="name"
                            label="Nome"
                            width="180"
                            sortable
                    ></el-table-column>
                    <el-table-column
                            v-if="fields.father_name && show_father_name"
                            prop="father_name"
                            label="Nome do pai"
                            width="180"
                            sortable
                    ></el-table-column>
                    <el-table-column
                            v-if="fields.mother_name && show_mother_name"
                            prop="mother_name"
                            label="Nome da mãe"
                            sortable
                    ></el-table-column>
                    <el-table-column
                            v-if="fields.gender && show_gender"
                            prop="gender"
                            label="Sexo"
                            width="100px"
                            sortable
                    ></el-table-column>
                    <el-table-column
                            v-if="fields.studding && show_studding"
                            prop="studding"
                            label="Estudaram"
                            width="120px"
                            sortable
                    ></el-table-column>
                    <el-table-column
                            v-if="fields.buss && show_buss"
                            prop="buss"
                            label="Linhas de onibus"
                            sortable
                    ></el-table-column>
                    <el-table-column
                            v-if="fields.disease_date && show_disease_date"
                            prop="disease_date"
                            label="Data da dengue"
                            sortable
                    ></el-table-column>
                    <el-table-column
                            v-if="fields.birthday && show_birthday"
                            prop="birthday"
                            label="Data nascimento"
                            sortable
                    ></el-table-column>
                </el-table>

            </el-collapse-item>
        </el-collapse>

    </div>
</template>
<script>
    export default {
        data() {
            return {
                uid: null,
                show: false,
                graphic: false,
                fields: {
                    index:true,
                    id: true,
                    name: true,
                    father_name: true,
                    mother_name: true,
                    gender: true,
                    studding: true,
                    buss: true,
                    disease_date: true,
                    birthday: true,
                }
            }
        },
        props: {
            hasChart: false,
            show_id: {default: true},
            show_name: {default: true},
            show_father_name: {default: true},
            show_mother_name: {default: true},
            show_gender: {default: true},
            show_studding: {default: true},
            show_buss: {default: true},
            show_disease_date: {default: true},
            show_birthday: {default: true},
            data: {
                required: true
            },
            title: {
                default: ''
            },
            total: {
                default: ''
            },
            a: {
                default: () => ({
                    text: '',
                    value: 0
                })
            },
            b: {
                default: () => ({
                    text: '',
                    value: 0
                })
            },
            ab: {
                default: () => ({
                    text: '',
                    value: 0
                })
            }

        },
        mounted() {
            this.fields.name = this.show_name;
            this.fields.father_name = this.show_father_name;
            this.fields.mother_name = this.show_mother_name;
            this.fields.gender = this.show_gender;
            this.fields.studding = this.show_studding;
            this.fields.buss = this.show_buss;
            this.fields.disease_date = this.show_disease_date;
            this.fields.birthday = this.show_birthday;
            this.uid = _.uniqueId('uuid-');
            let data = this.series;
            if (this.hasChart) {
                Highcharts.chart('teste', {
                    series: {
                        type: 'venn',
                        data,
                    }
                });
            }
        },
        computed: {
            series() {
                let series = [];
                series.push({
                    name: this.a.text,
                    sets: ['A'],
                    value: this.a.value,
                });
                series.push({
                    name: this.b.text,
                    sets: ['A'],
                    value: this.b.value,
                });
                series.push({
                    name: this.ab.text,
                    sets: ['A', 'B'],
                    value: this.ab.value,
                });

                return series;
            }
        }
    }
</script>