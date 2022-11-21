(()=>{"use strict";function t(t,e,n,s,a,i,r,o){var l,c="function"==typeof t?t.options:t;if(e&&(c.render=e,c.staticRenderFns=n,c._compiled=!0),s&&(c.functional=!0),i&&(c._scopeId="data-v-"+i),r?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),a&&a.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(r)},c._ssrRegister=l):a&&(l=o?function(){a.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:a),l)if(c.functional){c._injectStyles=l;var d=c.render;c.render=function(t,e){return l.call(e),d(t,e)}}else{var u=c.beforeCreate;c.beforeCreate=u?[].concat(u,l):[l]}return{exports:t,options:c}}const e=t({mixins:[Listing],props:{listingKey:String},data:function(){return{requestUrl:cp_url("customers")}}},(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[t.initializing?n("div",{staticClass:"card loading"},[n("loading-graphic")],1):t._e(),t._v(" "),t.initializing?t._e():n("data-list",{attrs:{columns:t.columns,rows:t.items,sort:!1,"sort-column":t.sortColumn,"sort-direction":t.sortDirection},scopedSlots:t._u([{key:"default",fn:function(e){e.hasSelections;return n("div",{},[n("div",{staticClass:"card p-0 relative"},[n("div",{staticClass:"data-list-header"},[n("data-list-search",{model:{value:t.searchQuery,callback:function(e){t.searchQuery=e},expression:"searchQuery"}})],1),t._v(" "),n("div",{directives:[{name:"show",rawName:"v-show",value:0===t.items.length,expression:"items.length === 0"}],staticClass:"p-3 text-center text-grey-50",domProps:{textContent:t._s(t.__("No results"))}}),t._v(" "),n("data-list-bulk-actions",{staticClass:"rounded",attrs:{url:t.actionUrl},on:{started:t.actionStarted,completed:t.actionCompleted}}),t._v(" "),n("data-list-table",{directives:[{name:"show",rawName:"v-show",value:t.items.length,expression:"items.length"}],attrs:{"allow-bulk-actions":!0},on:{sorted:t.sorted},scopedSlots:t._u([{key:"cell-email",fn:function(e){var s=e.row,a=e.value;return[n("a",{staticClass:"flex items-center",attrs:{href:s.edit_url}},[n("avatar",{staticClass:"w-8 h-8 rounded-full mr-1",attrs:{user:s}}),t._v("\n                            "+t._s(a)+"\n                        ")],1)]}},{key:"actions",fn:function(e){var s=e.row;e.index;return[n("dropdown-list",[n("dropdown-item",{attrs:{text:t.__("Edit"),redirect:s.edit_url}}),t._v(" "),n("data-list-inline-actions",{attrs:{item:s.id,url:t.actionUrl,actions:s.actions},on:{started:t.actionStarted,completed:t.actionCompleted}})],1)]}}],null,!0)})],1),t._v(" "),n("data-list-pagination",{staticClass:"mt-3",attrs:{"resource-meta":t.meta,"per-page":t.perPage},on:{"page-selected":t.selectPage,"per-page-changed":t.changePerPage}})],1)}}],null,!1,2845461203)})],1)}),[],!1,null,null,null).exports;const n=t({mixins:[Fieldtype],inject:["storeName"],data:function(){return{plan:this.value,confirming:!1}},computed:{formValues:function(){return this.$store.state.publish[this.storeName].values},trial:function(){if(this.plan.trial_ends_at){var t=new Date(this.plan.trial_ends_at),e=t.toISOString().split("T")[0];return t>(new Date).getDate()?"Trial will expire on ".concat(e):"Trial has expired on ".concat(e)}}},mounted:function(){console.log(this.formValues)},methods:{cancelSubscription:function(){var t=this;this.confirming=!1,Statamic.$request.post(cp_url("/customers/".concat(this.formValues.id,"/subscription/cancel"))).then((function(e){t.$toast.success(e.data.message,{duration:3e3}),t.plan=e.data.data.current_plan,t.update(t.plan)}))}}},(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[t.plan?n("div",[n("div",{staticClass:"help-block -mt-1"},[n("p",[n("b",[t._v(t._s(t.plan.product.name))])]),t._v(" "),n("p",[t._v(t._s(t.trial))])]),t._v(" "),n("button",{staticClass:"btn-danger",attrs:{type:"button",disabled:t.plan.ends_at},on:{click:function(e){t.confirming=!0}}},[t._v("\n            "+t._s(t.plan.ends_at?"Canceled":"Cancel Subscription")+"\n        ")])]):n("div",{staticClass:"help-block -mt-1"},[n("p",[t._v("No active plan.")])]),t._v(" "),t.confirming?n("confirmation-modal",{attrs:{title:"Cancel Subscription",bodyText:"Are you sure you want to cancel the subscription?",danger:"true"},on:{confirm:t.cancelSubscription,cancel:function(e){t.confirming=!1}}}):t._e()],1)}),[],!1,null,null,null).exports;const s=t({mixins:[Fieldtype],data:function(){return{}}},(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"page-tree w-full"},[t.value.length?n("div",{staticClass:"tree-node-children"},t._l(t.value,(function(e){return n("div",{key:e.id,staticClass:"tree-node",class:e.open?"open":""},[n("div",{staticClass:"tree-node-inner-back",staticStyle:{"margin-bottom":"1px"}},[n("div",{staticClass:"tree-node-inner"},[n("div",{staticClass:"flex"},[n("div",{staticClass:"w-6 m-1"},[n("svg",{staticClass:"text-grey-60",attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"}},[n("path",{attrs:{fill:"none",stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"1.5",d:"M21.75 9V6a1.5 1.5 0 0 0-1.5-1.5h-12V3a1.5 1.5 0 0 0-1.5-1.5h-4.5A1.5 1.5 0 0 0 .75 3v17.8a1.7 1.7 0 0 0 3.336.438l2.351-11.154A1.5 1.5 0 0 1 7.879 9H21.75a1.5 1.5 0 0 1 1.45 1.886l-2.2 10.5a1.5 1.5 0 0 1-1.45 1.114H2.447"}})])]),t._v(" "),n("div",{staticClass:"flex items-center flex-1 p-1 ml-1 text-xs leading-normal"},[n("div",{staticClass:"flex items-center flex-1"},[n("a",{staticClass:"text-sm font-medium"},[t._v(t._s(e.name))]),t._v(" "),n("button",{staticClass:"p-1 text-grey-60 hover:text-grey-70 transition duration-100 outline-none flex",on:{click:function(t){e.open=!e.open}}},[n("svg",{staticClass:"h-2.5",class:e.open?"":"-rotate-90",attrs:{viewBox:"0 0 10 6.5"}},[n("path",{attrs:{fill:"currentColor",d:"M9.9 1.4 5 6.4l-5-5L1.4 0 5 3.5 8.5 0l1.4 1.4z"}})])])])])])])]),t._v(" "),n("div",{staticClass:"tree-node-children"},t._l(e.notes,(function(s){return n("div",{staticClass:"tree-node open"},[n("div",{directives:[{name:"show",rawName:"v-show",value:e.open,expression:"folder.open"}],staticClass:"tree-node-inner-back",staticStyle:{"margin-bottom":"1px","padding-left":"24px"}},[n("div",{staticClass:"tree-node-inner"},[n("div",{staticClass:"flex"},[n("div",{staticClass:"w-6 m-1"},[n("svg",{staticClass:"text-grey-60",attrs:{viewBox:"0 0 16 16",xmlns:"http://www.w3.org/2000/svg"}},[n("g",{attrs:{fill:"none",stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round"}},[n("path",{attrs:{d:"M15.667 1A.667.667 0 0015 .333H3A.667.667 0 002.333 1v12a.667.667 0 00.667.667h12a.667.667 0 00.667-.667zM4.997 2.998h8M4.997 5.665h8M4.997 8.331h8M4.997 10.998h3.67","stroke-width":".66667"}}),t._v(" "),n("path",{attrs:{d:"M2.333 3H1a.667.667 0 00-.667.667V15a.667.667 0 00.667.667h11.333A.667.667 0 0013 15v-1.333","stroke-width":".66667"}})])])]),t._v(" "),n("div",{staticClass:"flex items-center flex-1 p-1 ml-1 text-xs leading-normal"},[n("div",{staticClass:"flex items-center flex-1"},[n("a",{attrs:{href:s.public_url,target:"_blank"}},[t._v(t._s(s.title))])]),t._v(" "),n("div",{staticClass:"pr-1 flex items-center"},[n("div",[t._v(t._s(s.last_modified))]),t._v(" "),n("div",{staticClass:"ml-2"},[t._v(t._s(s.formatted_size))])])])])])])])})),0)])})),0):n("div",[n("div",{staticClass:"help-block -mt-1"},[t._v("No records found.")])])])}),[],!1,null,null,null).exports;Statamic.booting((function(){Statamic.$components.register("customer-listing",e),Statamic.$components.register("subscription-fieldtype",n),Statamic.$components.register("notes_overview-fieldtype",s)})),Statamic.$conditions.add("hasPlan",(function(t){var e=t.values;return e.current_plan&&null==e.current_plan.ends_at})),Statamic.$conditions.add("hasTrial",(function(t){var e=t.values;if(e.current_plan&&null==e.current_plan.ends_at){var n=e.current_plan.trial_ends_at;return new Date(n)>(new Date).getDate()}return!1}))})();