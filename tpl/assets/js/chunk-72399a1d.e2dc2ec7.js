(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-72399a1d"],{"4add":function(t,e,a){"use strict";a.r(e);var o=function(){var t=this,e=t._self._c;return e("div",{directives:[{name:"loading",rawName:"v-loading",value:!t.isLoaded,expression:"!isLoaded"}],staticClass:"wbs-content-inner",class:{"wb-page-loaded":t.isLoaded}},[e("div",{staticClass:"wbs-main"},[e("table",{staticClass:"wbs-form-table"},[e("tbody",[e("tr",[e("th",{staticClass:"row w8em"},[t._v("索引")]),e("td",{staticClass:"info"},[e("el-radio-group",{on:{change:function(e){return t.set_noindex(e)}},model:{value:t.noindex,callback:function(e){t.noindex=e},expression:"noindex"}},[e("el-radio",{attrs:{label:0}},[t._v("索引")]),e("el-radio",{attrs:{label:1}},[t._v("不索引")])],1)],1)]),e("tr",[e("th",{staticClass:"row"},[t._v("跟随")]),e("td",{staticClass:"info"},[e("el-radio-group",{on:{change:function(e){return t.set_nofollow(e)}},model:{value:t.nofollow,callback:function(e){t.nofollow=e},expression:"nofollow"}},[e("el-radio",{attrs:{label:0}},[t._v("跟随")]),e("el-radio",{attrs:{label:1}},[t._v("不跟随")])],1)],1)]),e("tr",[e("th",{staticClass:"row"},[t._v("选项")]),e("td",{staticClass:"info"},[e("el-radio-group",{model:{value:t.opt.category_mode,callback:function(e){t.$set(t.opt,"category_mode",e)},expression:"opt.category_mode"}},[e("el-radio",{attrs:{label:"1"}},[t._v("简易模式")]),e("el-radio",{attrs:{label:"2"}},[t._v("高级模式")])],1)],1)])])]),1==t.opt.category_mode?e("div",[e("wbs-tdk-setter",{attrs:{cnf:{separator:t.opt.separator,titleVariables:t.title_variables,kwMode:0},opt:t.opt.term_base},on:{change:function(e){t.opt.term_base=e}}})],1):t._e(),2==t.opt.category_mode?e("div",[e("table",{staticClass:"wbs-form-table"},[e("tbody",[e("tr",[e("th",{staticClass:"row w8em"},[t._v("选择分类")]),e("td",{staticClass:"info"},[e("div",{staticClass:"wbs-ctrl-bar"},[t.all_taxonomy.length>1?e("el-select",{staticClass:"ctrl-item",attrs:{clearable:"",filterable:"",placeholder:"所有类型"},on:{change:function(e){return t.change_taxonomy()}},model:{value:t.taxonomy,callback:function(e){t.taxonomy=e},expression:"taxonomy"}},t._l(t.all_taxonomy,(function(t,a){return e("el-option",{key:a,attrs:{label:t.name,value:t.id}})})),1):t._e(),t.list_cate.length>0?e("el-select",{staticClass:"ctrl-item ml",attrs:{clearable:"",filterable:"",placeholder:"所有分类"},on:{change:function(e){return t.change_category()}},model:{value:t.category,callback:function(e){t.category=e},expression:"category"}},t._l(t.list_cate,(function(t,a){return e("el-option",{key:a,attrs:{label:t.name,value:t.term_id}})})),1):t._e()],1)])])])]),""!=t.category&&t.isReload?e("wbs-tdk-setter",{attrs:{cnf:{separator:t.opt.separator,titleVariables:t.title_variables},opt:t.cur_cate},on:{change:function(e){return t.update_term_tdk(e)}}}):t._e()],1):t._e(),e("wbs-var-doc",{directives:[{name:"show",rawName:"v-show",value:t.isLoaded,expression:"isLoaded"}]}),e("wb-prompt",{directives:[{name:"show",rawName:"v-show",value:t.isLoaded,expression:"isLoaded"}],staticClass:"mt"})],1),t.$cnf.is_pro?t._e():e("wbs-more-sources",{directives:[{name:"show",rawName:"v-show",value:t.isLoaded,expression:"isLoaded"}]}),e("wbs-ctrl-bar",{on:{submit:t.updateData}})],1)},n=[],s=a("46d5"),l=a("6bd9"),r={name:"TdkCategory",components:{"wbs-tdk-setter":s["a"],"wbs-var-doc":l["a"]},data(){const t=this;return{formChanged:0,isLoaded:!1,is_pro:t.$cnf.is_pro,opt:{},all_taxonomy:[],all_category:[],list_cate:[],separator:[],title_variables:{},taxonomy:"",category:"",noindex:0,nofollow:0,cur_cate:["","",""],isReload:1}},computed:{},created(){const t=this;t.getData()},methods:{reload(){this.isReload=!1,this.$nextTick(()=>this.isReload=!0)},set_noindex(t){const e=this;let a=e.opt.noindex.indexOf("category");t&&a<0?e.opt.noindex.push("category"):!t&&a>-1&&e.opt.noindex.splice(a,1)},set_nofollow(t){const e=this;let a=e.opt.nofollow.indexOf("category");t&&a<0?e.opt.nofollow.push("category"):!t&&a>-1&&e.opt.nofollow.splice(a,1)},update_term_tdk(t){const e=this;e.category&&(e.opt[e.category]=t)},change_category(){const t=this;t.cur_cate=["","",""],t.category&&t.opt[t.category]&&(t.cur_cate=t.opt[t.category]),t.reload()},change_taxonomy(){const t=this;t.category="",t.cur_cate=["","",""],t.list_cate=[],t.all_category.length<1||""!=t.taxonomy&&t.all_category[t.taxonomy]&&(t.list_cate=t.all_category[t.taxonomy],t.reload())},getData(){const t=this;t.$api.getData({action:t.$cnf.action.act,op:"get_options",key:"tdk",type:"category"}).then(e=>{const a=e.data;t.opt=a.opt,t.opt.nofollow||(t.opt.nofollow=[]),t.opt.noindex&&t.opt.noindex.indexOf("category")>-1&&(t.noindex=1),t.opt.nofollow&&t.opt.nofollow.indexOf("category")>-1&&(t.nofollow=1),t.separator=a.separator,t.title_variables=a.title_variables["category"],t.all_taxonomy=a.all_taxonomy,t.all_category=a.all_category,1==t.all_taxonomy.length&&(t.taxonomy=t.all_taxonomy[0].id,t.change_taxonomy()),t.$nextTick(()=>{t.formChanged=0}),t.isLoaded=!0})},updateData(t){const e=this;e.$api.saveData({_ajax_nonce:_wb_sst_ajax_nonce||"",action:e.$cnf.action.act,op:"update_options",opt:e.opt,key:"tdk",type:"category"}).then(a=>{e.$wbui.toast("设置保存成功"),e.formChanged=0,t&&t()})}},watch:{opt:{handler(){this.formChanged++},deep:!0}},beforeRouteLeave(t,e,a){const o=this;o.formChanged>0?o.$wbui.open({content:"您修改的设置尚未保存，确定离开此页面吗？",btn:["保存并离开","放弃修改"],yes(){return a(!1),o.updateData(()=>{a()}),!1},no(){return a(),!1}}):a()}},i=r,c=a("2877"),d=Object(c["a"])(i,o,n,!1,null,null,null);e["default"]=d.exports},"6bd9":function(t,e,a){"use strict";var o=function(){var t=this,e=t._self._c;return e("table",{staticClass:"wbs-form-table mt"},[e("tbody",[e("tr",[e("th",{staticClass:"row w8em"}),e("td",[e("el-button",{attrs:{size:"medium",type:"primary",plain:"",icon:"el-icon-collection"},on:{click:function(e){t.unfold=!t.unfold}}},[t._v("变量注释")]),e("table",{directives:[{name:"show",rawName:"v-show",value:t.unfold,expression:"unfold"}],staticClass:"wbs-table wbs-table-doc table-hover mt"},[t._m(0),e("tbody",t._l(t.doc_items,(function(a){return e("tr",{key:a.name},[e("td",[e("b",[t._v(t._s(a.name))])]),e("td",{domProps:{innerHTML:t._s(a.desc)}})])})),0)])],1)])])])},n=[function(){var t=this,e=t._self._c;return e("thead",[e("tr",[e("td",[t._v("变量名称")]),e("td",[t._v("变量说明")])])])}],s={name:"comVariableDoc",props:{type:{type:String,value:""}},data(){return{doc_items:[],unfold:!1}},created(){const t=this,e="WB_SST_DOC"+(t.type?"_"+t.type:"");let a=localStorage.getItem(e);a=a?JSON.parse(a):null,a&&a.ver==t.$cnf.pd_version?t.doc_items=a.data:t.$api.getData({action:t.$cnf.action.act,op:"doc",type:t.type?t.type:""}).then(a=>{t.doc_items=a["data"],localStorage.setItem(e,JSON.stringify({ver:t.$cnf.pd_version,data:a["data"]}))})}},l=s,r=a("2877"),i=Object(r["a"])(l,o,n,!1,null,null,null);e["a"]=i.exports}}]);