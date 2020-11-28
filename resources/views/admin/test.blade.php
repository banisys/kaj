<div class="sidebar mt-4">
    <div class="widget" style="text-align: right">

        <input type="text" v-model="search"
               style="border-radius: 4px;border: 1px #dddddd solid;padding: 5px 10px;width: 100%;color: #494949"
               placeholder="جستجوی نام برند"/>

        <div class="filter-dropdown"
             style="padding:5px 15px;background-color: white;border: 1px solid #dddddd">
            <ul class="filter-checkboxes mt-3">
                <li v-for="brand in filteredList" class="categor-li">
                    <input class="checked" type="checkbox" style="opacity: 0;"
                           :value="brand.name"
                           :id="replaceUnder(brand.name)"
                           @change="changeBrand(brand.name)">
                    <label class="pr-4" :for="replaceUnder(brand.name)">
                        <div class="col-12 float-right" style="padding: 0 7px;">
                            <span style="margin-right: 20px">@{{ brand.name }}</span>
                            <span style="float: left;color: grey">@{{ brand.name_f }}</span>
                        </div>
                    </label>
                </li>
            </ul>
        </div>

    </div>
</div>
