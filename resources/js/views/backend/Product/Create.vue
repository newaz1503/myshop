<template>
    <div class="row">
        <form
            v-on:submit.prevent="submit"
            enctype="multipart/form-data"
            id="form"
            class="row"
        >
            <div class="col-8">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form row">
                                <Input col="8" title="Name" field="name" :req="true"/>
                                <Input col="4" title="SKU Code" field="sku_code" :req="true"/>
                                <!------------ Single Input ------------>
                                <div class="form-group col-12 "
                                     :class="{
                                        'has-error': validation.hasError('data.featured_image'),
                                        'has-success': data.featured_image,
                                      }">
                                    <label for="featured_image" class="image-dragable-box">
                                        <label class="control-label">Featured Image</label>
                                        <div class="preview-box" ondrag="onFileChange($event)"
                                             ondragover="onFileChange($event)">
                                            <img :src="
                                                image.featured_image
                                                  ? image.featured_image
                                                  : data.featured_image
                                                  ? data.featured_image
                                                  : $root.noimage
                                              "
                                                 alt="picture" class="img-responsive choose-file-size">
                                            <input
                                                id="featured_image"
                                                type="file"
                                                name="featured_image"
                                                draggable="true"
                                                class="d-none"
                                                v-on:change="onFileChange($event)"
                                            >
                                            <h5>Select your featured image</h5>
                                        </div>
                                    </label>
                                    <span class="help-block">
                                        {{ validation.firstError("data.featured_image")}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h3>Product Gallery</h3>
                        </div>
                        <div class="card-body">
                            <div class="form row">
                                <div class="col-2 mb-2"
                                     v-if="productGalleryImage && Object.keys(productGalleryImage).length > 0"
                                     v-for="(img,index) in productGalleryImage" :key="index">
                                    <div class="gallery_image">
                                        <a href="javascript:" class="image-remove-button"
                                           @click="removeSelectedImage(index)">
                                            <i class="mdi mdi-trash-can-outline"></i>
                                        </a>
                                        <img :src="typeof img == 'string' ? img : data.product_gallery
                                          ? data.product_gallery[index]
                                          : $root.noimage" class="img-responsive gallery_preview_image"
                                        >
                                    </div>
                                </div>
                                <div class="col-2 mb-2">
                                    <div class="gallery_image">
                                        <label for="gallery_image" class="gellary-dragable-box">
                                            <i class="mdi mdi-plus "></i>
                                            <input
                                                accept="image/png, image/jpg, image/jpeg"
                                                id="gallery_image"
                                                type="file"
                                                class="d-none"
                                                v-on:change="addProductGalleryImage($event)"
                                            >
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center pb-0">
                            <h3>Price & Stock</h3>
                            <div class="form-check form-switch form-switch-lg" dir="ltr">
                                <input type="checkbox" v-model="is_variant" value="1" class="form-check-input"
                                       id="isValriant">
                                <label class="form-check-label" for="isValriant">Variant Product</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form row">
                                <Input col="6" title="Original Price" field="sale_price" :req="true"/>
                                <Input col="6" title="Total in stock " field="quantity" :req="true"/>
                            </div>
                            <div class="form row" v-if="is_variant">
                                <div class="col-6">
                                    <select @change="setAttribute($event,'attributeValues1')" class="form-select">
                                        <option value="">Select One</option>
                                        <option v-for="(attribute,akey) in attributes1" :key="akey"
                                                :value="attribute.id">{{ attribute.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-2 col-6">
                                    <b-form-group
                                        class="w-100 similar-product-selector"
                                        label-for="tags-with-dropdown"
                                    >
                                        <b-form-tags
                                            id="tags-with-dropdown"
                                            no-outer-focus
                                            class="mb-2"
                                        >
                                            <template v-slot="{ disabled }">
                                                <b-dropdown
                                                    size="sm"
                                                    variant="outline-light"
                                                    block
                                                    menu-class="w-100 text-start"
                                                >
                                                    <template #button-content>Select One</template>
                                                    <b-dropdown-form @submit.stop.prevent="() => {}">
                                                        <b-form-group
                                                            label="Search Value"
                                                            label-for="tag-search-input"
                                                            label-cols-md="auto"
                                                            class="mb-0"
                                                            label-size="sm"
                                                            description="searchDesc"
                                                            disabled="disabled"
                                                            placeholder="type your product name"
                                                        >
                                                            <b-form-input
                                                                id="tag-search-input"
                                                                type="search"
                                                                size="sm"
                                                                autocomplete="off"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-dropdown-form>
                                                    <b-dropdown-item-button
                                                        v-for="(option, index) in availableAttributeValues1"
                                                        :key="index"
                                                        @click="selectedAattributeValue(option,'attributes1')"
                                                    >
                                                        <div class="d-flex align-items-center">
                                                            <span>{{ option.value }}</span>
                                                        </div>
                                                    </b-dropdown-item-button>
                                                    <b-dropdown-text v-if="availableAttributeValues1.length === 0">
                                                        There are no product available to select
                                                    </b-dropdown-text>
                                                </b-dropdown>
                                            </template>
                                        </b-form-tags>
                                    </b-form-group>
                                </div>
                                <div class="mb-2 col-6">
                                    <select @change="setAttribute($event,'attributeValues2')" class="form-select">
                                        <option value="">Select One</option>
                                        <option v-for="(attribute,akey) in attributes2" :key="akey"
                                                :value="attribute.id">{{ attribute.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-2 col-6">
                                    <b-form-group
                                        class="w-100 similar-product-selector"
                                        label-for="tags-with-dropdown"
                                    >
                                        <b-form-tags
                                            id="tags-with-dropdown"
                                            no-outer-focus
                                            class="mb-2"
                                        >
                                            <template v-slot="{ disabled }">
                                                <b-dropdown
                                                    size="sm"
                                                    variant="outline-light"
                                                    block
                                                    menu-class="w-100 text-start"
                                                >
                                                    <template #button-content>Select One</template>
                                                    <b-dropdown-form @submit.stop.prevent="() => {}">
                                                        <b-form-group
                                                            label="Search Value"
                                                            label-for="tag-search-input"
                                                            label-cols-md="auto"
                                                            class="mb-0"
                                                            label-size="sm"
                                                            description="searchDesc"
                                                            disabled="disabled"
                                                            placeholder="type your product name"
                                                        >
                                                            <b-form-input
                                                                id="tag-search-input"
                                                                type="search"
                                                                size="sm"
                                                                autocomplete="off"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-dropdown-form>
                                                    <b-dropdown-item-button
                                                        v-for="(option, index) in availableAttributeValues2"
                                                        :key="index"
                                                        @click="selectedAattributeValue(option,'attributes2')"
                                                    >
                                                        <div class="d-flex align-items-center">
                                                            <span>{{ option.value }}</span>
                                                        </div>
                                                    </b-dropdown-item-button>
                                                    <b-dropdown-text v-if="availableAttributeValues2.length === 0">
                                                        There are no product available to select
                                                    </b-dropdown-text>
                                                </b-dropdown>
                                            </template>
                                        </b-form-tags>
                                    </b-form-group>
                                </div>
                                <div class="mb-2 col-6">
                                    <select @change="setAttribute($event,'attributeValues3')" class="form-select">
                                        <option value="">Select One</option>
                                        <option v-for="(attribute,akey) in attributes3" :key="akey"
                                                :value="attribute.id">{{ attribute.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-2 col-6">
                                    <b-form-group
                                        class="w-100 similar-product-selector"
                                        label-for="tags-with-dropdown"
                                    >
                                        <b-form-tags
                                            id="tags-with-dropdown"
                                            no-outer-focus
                                            class="mb-2"
                                        >
                                            <template v-slot="{ disabled }">
                                                <b-dropdown
                                                    size="sm"
                                                    variant="outline-light"
                                                    block
                                                    menu-class="w-100 text-start"
                                                >
                                                    <template #button-content>Select One</template>
                                                    <b-dropdown-form @submit.stop.prevent="() => {}">
                                                        <b-form-group
                                                            label="Search Value"
                                                            label-for="tag-search-input"
                                                            label-cols-md="auto"
                                                            class="mb-0"
                                                            label-size="sm"
                                                            description="searchDesc"
                                                            disabled="disabled"
                                                            placeholder="type your product name"
                                                        >
                                                            <b-form-input
                                                                id="tag-search-input"
                                                                type="search"
                                                                size="sm"
                                                                autocomplete="off"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-dropdown-form>
                                                    <b-dropdown-item-button
                                                        v-for="(option, index) in availableAttributeValues3"
                                                        :key="index"
                                                        @click="selectedAattributeValue(option,'attributes3')"
                                                    >
                                                        <div class="d-flex align-items-center">
                                                            <span>{{ option.value }}</span>
                                                        </div>
                                                    </b-dropdown-item-button>
                                                    <b-dropdown-text v-if="availableAttributeValues3.length === 0">
                                                        There are no product available to select
                                                    </b-dropdown-text>
                                                </b-dropdown>
                                            </template>
                                        </b-form-tags>
                                    </b-form-group>
                                </div>
                                <div class="row align-items-center mb-2"
                                     v-for="(variant,variantKey) in data.variant_product" :key="variantKey">
                                    <div class="col pe-1">
                                        <strong v-if="variantKey == 0" class="d-block mb-1">Attribute</strong>
                                        <div class="">
                                            <input readonly type="text" v-model="variant.attribute_name"
                                                   class="form-control"
                                                   :name="`variant_product[${variantKey}][attribute_name]`">
                                        </div>
                                    </div>
                                    <div class="col px-1">
                                        <strong v-if="variantKey == 0" class="d-block mb-1">Value</strong>
                                        <div class="">
                                            <input type="text" readonly
                                                   v-model="variant.attribute_value" class="form-control"
                                                   :name="`variant_product[${variantKey}][attribute_value]`">
                                        </div>
                                    </div>
                                    <div class="col px-0">
                                        <strong v-if="variantKey == 0" class="d-block mb-1">Addition Price</strong>
                                        <input type="number" :name="`variant_product[${variantKey}][price]`"
                                               v-model="variant.price" class="variant-input-field">
                                    </div>
                                    <div class="col px-0">
                                        <strong v-if="variantKey == 0" class="d-block mb-1">Stock</strong>
                                        <input type="number" :name="`variant_product[${variantKey}][stock]`"
                                               v-model="variant.stock" class="variant-input-field">
                                    </div>
                                    <div class="col px-0">
                                        <strong v-if="variantKey == 0" class="d-block mb-1">SKU</strong>
                                        <input type="number" :name="`variant_product[${variantKey}][sku]`"
                                               v-model="variant.sku" class="variant-input-field">
                                    </div>
                                    <div class="col px-0">
                                        <strong v-if="variantKey == 0" class="d-block mb-1">Image</strong>
                                        <div class="variant-file-field">
                                            <img v-if="variant.image" :src="variant.image" alt="">
                                            <input @change="fileChangeHandler($event,variantKey)"
                                                   :name="`variant_product[${variantKey}][image]`" type="file"
                                                   accept="image/png, image/jpg, image/jpeg">
                                        </div>
                                    </div>
                                    <div class="action-button">
                                        <a v-if="data.variant_product.length > 0"
                                           @click="removeAttributeValue(variantKey,variant)" class="btn btn-danger"
                                           href="javascript:"><i class="bx bx-x"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center pb-0">
                            <h3>Price & Stock</h3>
                            <div class="form-check form-switch form-switch-lg" dir="ltr">
                                <input type="checkbox" v-model="is_variant" value="1" class="form-check-input"
                                       id="isValriant">
                                <label class="form-check-label" for="isValriant">Variant Product</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form row" v-if="!is_variant">
                                <Input col="6" title="Original Price" field="sale_price" :req="false"/>
                                <Input col="6" title="Total in stock " field="quantity" :req="false"/>
                            </div>
                            <template v-if="is_variant">
                                <div class="form row" v-for="(variant,vkey) in data.product_variations" :key="vkey">
                                    <div class="form-group col-4">
                                        <input type="text" v-model="variant.attribute_name" name="attribute_name"
                                               class="form-control" placeholder="Attribute Name">
                                    </div>
                                    <div class="form-group col-4">
                                        <input type="text" v-model="variant.attribute_price" name="attribute_price"
                                               class="form-control" placeholder="Price">
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h3>Product Tags & Specifications</h3>
                        </div>
                        <div class="card-body">
                            <div class="form row">
                                <div class="col-lg-12">
                                    <div class="alert alert-success">
                                        <i class="ri-information-fill"></i> If you have multiple specification values
                                        you can separate with <strong>/</strong>, the system will automatically create
                                        the option on the product details page
                                    </div>
                                    <div class="row align-items-center mb-2"
                                         v-for="(specification,key) in data.specifications" :key="key">
                                        <div class="col-lg-10">
                                            <div class="row">
                                                <div class="col-lg-4 pe-0">
                                                    <input
                                                        type="text"
                                                        :name="`specifications[${key}][spec_name]`"
                                                        class="form-control"
                                                        placeholder="Spec. name"
                                                        v-model="specification.spec_name"
                                                    >
                                                </div>
                                                <div class="col-lg-8 pe-0">
                                                    <textarea
                                                        class="form-control"
                                                        :name="`specifications[${key}][spec_values]`"
                                                        placeholder="Spec. value"
                                                        v-model="specification.spec_values"
                                                        rows="1">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 text-end">
                                            <a href="javascript:" v-show="Object.keys(data.specifications).length > 1"
                                               @click="data.specifications.splice(key,1)" class="btn btn-danger btn-sm">
                                                <i class="fa fa-times"></i>
                                            </a>
                                            <a href="javascript:" v-show="key == data.specifications.length -1"
                                               @click="data.specifications.push({})" class="btn btn-primary btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-3">
                                    <label for="tags-basic" class="form-label">Meta Keywords </label>
                                    <b-form-tags
                                        input-id="tags-basic"
                                        v-model="data.meta_keyword">
                                    </b-form-tags>
                                </div>
                                <div class="col-sm-12">
                                    <label class="form-label">Meta Description </label>
                                    <textarea
                                        class="form-control"
                                        name="site_meta_description"
                                        v-model="data.meta_description"
                                        id=""
                                        rows="4">
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form row">
                                <Textarea title="Short Description" field="short_description" :req="false" col="12"/>
                                <!------------ Single Input ------------>
                                <div class="form-group col-12">
                                    <label class="col-12 p-0">Description</label>
                                    <div class="col-12 p-0">
                                        <editor :editorModel="'description'"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <!------------ Single Input ------------>
                                <Input
                                    title="Sorting"
                                    field="sorting"
                                    type="number"
                                    :req="true"
                                    col="4"
                                />
                                <!------------ Single Input ------------>
                                <Radio
                                    title="Status"
                                    field="status"
                                    statusTitle1="Active"
                                    statusTitle2="Deactive"
                                    value1="active"
                                    value2="deactive"
                                    :req="true"
                                    col="6"
                                />
                                <div class="col-4">
                                    <div class="form-check form-switch form-switch-lg" dir="rtl">
                                        <input type="checkbox" v-model="data.hot" value="1" name="hot"
                                               class="form-check-input" id="isHotProduct">
                                        <label class="form-check-label" for="isHotProduct">Hot Product</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check form-switch form-switch-lg" dir="rtl">
                                        <input type="checkbox" v-model="data.top_selling" value="1" name="top_selling"
                                               class="form-check-input" id="isTopSellingProduct">
                                        <label class="form-check-label" for="isTopSellingProduct">Top Selling
                                            Product</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check form-switch form-switch-lg" dir="rtl">
                                        <input type="checkbox" v-model="data.trending_product" value="1"
                                               name="trending_product" class="form-check-input" id="isTrendingProduct">
                                        <label class="form-check-label" for="isTrendingProduct">Trending Product</label>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <router-link :to="{name:model + '.index'}"
                                                 class="me-4 btn btn-xs btn-primary btn-border add-and-back  pull-left text-white router-link-active"
                                                 title="Back to list"><i class="mdi mdi-arrow-left"></i>
                                        <span><b>Back to list</b></span>
                                    </router-link>
                                    <Button class="px-4" title="Save & Exit" process=""/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!------------ Single Input ------------>
                            <Input col="12" title="Barcode" field="barcode" :req="true"/>
                            <!------------ Single Input ------------>
                            <Input col="12" max="5" type="number" title="Rating" field="rating" :req="true"/>
                            <!------------ Single Custom Select ------------>
                            <div class="form-group col" :class="{
                                'has-error': validation.hasError('data.vendor_id'),
                                'has-success': data.vendor_id,
                              }">
                                <label for="" class="control-label">Select Vendor</label>
                                <v-select
                                    :options="vendors"
                                    :reduce="vendor => vendor.id"
                                    label="name"
                                    v-model="data.vendor_id"
                                />
                                <span class="help-block">
                                    {{ validation.firstError("data.vendor_id")}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h3>Category & Brand</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group col" :class="{
                                'has-error': validation.hasError('data.category_id'),
                                'has-success': data.category_id,
                              }">
                                <label for="">Category</label>
                                <v-select
                                    :options="categories"
                                    :reduce="category => category.id"
                                    label="title"
                                    v-model="data.category_id"
                                />
                                <span class="help-block">
                                    {{ validation.firstError("data.category_id")}}
                                </span>
                            </div>
                            <div class="form-group col">
                                <label for="">Sub Category</label>
                                <v-select
                                    :options="subCategories"
                                    :reduce="sub => sub.id"
                                    label="title"
                                    v-model="data.sub_category_id"
                                />
                            </div>
                            <div class="form-group col">
                                <label for="">Child Category</label>
                                <v-select
                                    :options="childCategories"
                                    :reduce="child => child.id"
                                    label="title"
                                    v-model="data.child_category_id"
                                />
                            </div>
                            <div class="col form-group" :class="{
                                'has-error': validation.hasError('data.brand_id'),
                                'has-success': data.brand_id,
                              }">
                                <label for="" class="control-label">Select Brand</label>
                                <v-select
                                    :options="brands"
                                    :reduce="brand => brand.id"
                                    label="name"
                                    v-model="data.brand_id"
                                />
                                <span class="help-block">
                                    {{ validation.firstError("data.brand_id")}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h3>Discount, Unit</h3>
                        </div>
                        <div class="card-body">
                            <Input col="12" title="Unit" field="unit" :req="false"/>
                            <!------------ Single Input ------------>
                            <Select
                                col="12"
                                v-if="discount_types"
                                title="Discount Type"
                                field="discount_type"
                                :req="true"
                                :datas="discount_types"
                            />
                            <Input
                                col="12"
                                type="number"
                                title="Discount Amount"
                                field="discount_amount"
                                :req="true"/>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h3>Vat & Tax</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-6 " :class="{
                                    'has-error': validation.hasError('data.vat_amount'),
                                    'has-success': data.vat_amount,
                                  }">
                                    <label class="">Vat</label>
                                    <input name="vat_amount" v-model="data.vat_amount" placeholder="Vat" type="number"
                                           class="form-control">
                                    <span class="help-block">
                                        {{ validation.firstError("data.vat_amount") }}
                                    </span>
                                </div>
                                <div class="form-group col-6">
                                    <label class=""></label>
                                    <select name="vat_type" v-model="data.vat_type" class="form-select mt-2">
                                        <option value="flat">Flat</option>
                                        <option value="percent">Percent</option>
                                    </select>
                                </div>
                                <div class="form-group col-6 " :class="{
                                        'has-error': validation.hasError('data.tax_amount'),
                                        'has-success': data.tax_amount,
                                      }">
                                    <label class="">Tax</label>
                                    <input name="tax_amount" v-model="data.tax_amount" placeholder="Tax" type="number"
                                           class="form-control">
                                    <span class="help-block">
                                        {{ validation.firstError("data.tax_amount") }}
                                    </span>
                                </div>
                                <div class="form-group col-6">
                                    <label class=""></label>
                                    <select v-model="data.tax_type" name="tax_type" class="form-select mt-2">
                                        <option value="flat">Flat</option>
                                        <option value="percent">Percent</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    // define model name
    const model = "product";
    export default {
        data() {
            return {
                model: model,
                is_variant: true,
                data: {
                    featured_image: "",
                    product_gallery: [],
                    sorting: 0,
                    status: 'active',
                    category_id: '',
                    sub_category_id: '',
                    child_category_id: '',
                    brand_id: '',
                    rating: 0,
                    vendor_id: '',
                    unit_type_id: '',
                    discount_type: 'flat',
                    discount_amount: '0',
                    vat_type: 'flat',
                    vat_amount: '0',
                    tax_type: 'flat',
                    tax_amount: '0',
                    specifications: [
                        {
                            spec_name: '',
                            spec_values: '',
                        }
                    ],
                    product_variations: [
                        {
                            is_default: false,
                            attribute_name: '',
                            attribute_price: ''
                        }
                    ],
                    variant_product: [],
                    meta_keyword: [],
                    meta_description: '',
                },
                image: {featured_image: ''},
                errors: {},

                categories: [],
                subCategories: [],
                childCategories: [],

                brands: [],
                units: [],
                vendors: [],
                attributes1: [],
                attributes2: [],
                attributes3: [],
                attrValues: {
                    attributeValues1: [],
                    attributeValues2: [],
                    attributeValues3: [],
                },
                selectedAttrValues: [],
                discount_types: {
                    flat: "Flat",
                    percent: "Percent",
                },
                tax_type: {
                    flat: "Flat",
                    percent: "Percent",
                },
                vat_type: {
                    flat: "Flat",
                    percent: "Percent",
                },
                productGalleryImage: [],
            };
        },
        watch: {
            'data.category_id'(value) {
                this.getSubCategories(value);
            },
            'data.sub_category_id'(value) {
                this.getChildCategories(value);
            },
            'data.specifications'(value) {
                if (!value) {
                    this.data.specifications = [{}]
                }
            },

        },
        computed: {
            availableAttributeValues1() {
                return this.attrValues.attributeValues1.filter(opt => this.selectedAttrValues.indexOf(opt) === -1)
            },
            availableAttributeValues2() {
                return this.attrValues.attributeValues2.filter(opt => this.selectedAttrValues.indexOf(opt) === -1)
            },
            availableAttributeValues3() {
                return this.attrValues.attributeValues3.filter(opt => this.selectedAttrValues.indexOf(opt) === -1)
            }
        },
        methods: {
            submit: function () {
                this.$validate().then((res) => {
                    const error = this.validation.countErrors();
                    // If there is an error
                    if (error > 0) {
                        console.log(this.validation.allErrors());
                        this.notification(
                            "You need to fill " + error + " more empty mandatory fields",
                            "warning"
                        );
                        return false;
                    }

                    // If there is no error
                    if (res) {
                        var form = document.getElementById("form");
                        var formData = new FormData(form);
                        if (this.data.description) {
                            formData.append("description", this.data.description);
                        } else {
                            formData.append("description", "");
                        }
                        if (this.data.category_id) {
                            formData.append("category_id", this.data.category_id);
                        }
                        if (this.data.brand_id) {
                            formData.append("brand_id", this.data.brand_id);
                        }
                        if (this.data.vendor_id) {
                            formData.append("vendor_id", this.data.vendor_id);
                        }
                        if (Object.keys(this.productGalleryImage).length > 0) {
                            this.productGalleryImage.forEach((img, index) => {
                                formData.append(`product_gallery[${index}]`, img);
                            })
                        }
                        if (this.data.slug) {
                            this.update(this.model, formData, this.data.slug, 'image');
                        } else {
                            this.store(this.model, formData);
                        }
                    }
                });
            },
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (files.length) {
                    this.data.featured_image = e.target.files[0];
                    this.image.featured_image = URL.createObjectURL(e.target.files[0]);
                }
            },
            addProductGalleryImage(e) {
                let preUrl = URL.createObjectURL(e.target.files[0]);
                // Add in state
                this.data.product_gallery.push(preUrl);
                // push a new array in preview image
                this.productGalleryImage.push(e.target.files[0])
            },
            removeSelectedImage(index) {
                this.data.product_gallery.splice(index, 1)
                this.productGalleryImage.splice(index, 1)
            },
            selectedAattributeValue(option, attributes) {
                let self = this;
                let attributeName = '';
                self[attributes].filter(obj => {
                    if (obj.id == option.attribute_id) {
                        attributeName = obj.name;
                    }
                });
                this.selectedAttrValues.push(option)
                this.data.variant_product.push({
                    attribute_name: attributeName,
                    attribute_value: option.value,
                    price: '',
                    stock: '',
                    sku: '',
                    image: '',
                });
            },
            removeAttributeValue(index, option) {
                this.selectedAttrValues.splice(index, 1)
                this.data.variant_product.splice(index, 1);
            },
            fileChangeHandler(e, variableIndex) {
                let files = e.target.files || e.dataTransfer.files;
                if (files.length) {
                    this.data.variant_product[variableIndex].image = URL.createObjectURL(e.target.files[0]);
                }
            },
            setAttribute(event, attValueNo) {
                const attributeId = event.target.value;
                this.getAttributeValue(attributeId, attValueNo);
            },
            getAttributeValue(id, valueNo) {
                axios.get('attribute-value/' + id).then(res => {
                    this.attrValues[valueNo] = res.data;
                }).catch(error => {
                    console.log(error)
                })
            },
            getSubCategories(id) {
                axios.get('get-sub-categories/' + id).then(res => {
                    this.subCategories = res.data;
                })
            },
            getChildCategories(id) {
                axios.get('get-child-categories/' + id).then(res => {
                    this.childCategories = res.data;
                })
            }
        },
        created() {
            if (this.$route.params.id) {
                this.setBreadcrumbs(this.model, "edit");
                axios.get(this.model + '/' + this.$route.params.id).then(res => {
                    this.data = res.data;
                    this.productGalleryImage = res.data.product_gallery;
                }).catch(error => {
                    console.log(error)
                });
                this.get_data(this.model, this.$route.params.id, "data");
            } else {
                this.setBreadcrumbs(this.model, "create");
                this.get_sorting('Product')
            }
            axios.get('brands').then(res => this.brands = res.data);
            axios.get('categories').then(res => this.categories = res.data);
            axios.get('vendors').then(res => this.vendors = res.data);
            axios.get('attributes').then(res => {
                this.attributes1 = res.data
                this.attributes2 = res.data
                this.attributes3 = res.data
            });
        },

        // ================== validation rule for form ==================
        validators: {
            "data.name": function (value = null) {
                return Validator.value(value).required("Name is required");
            },
            "data.featured_image": function (value = null) {
                return Validator.value(value).required("Featured is required");
            },
            "data.category_id": function (value = null) {
                return Validator.value(value).required("Category is required");
            },
            "data.brand_id": function (value = null) {
                return Validator.value(value).required("Brand is required");
            },
            "data.vendor_id": function (value = null) {
                return Validator.value(value).required("Vendor is required");
            },
            // "data.purchase_price": function (value = null) {
            //     return Validator.value(value).digit().required("Purchase Price is required");
            // },
            "data.sale_price": function (value = null) {
                return Validator.value(value).digit().required("Sale Price is required");
            },
            "data.quantity": function (value = null) {
                return Validator.value(value).digit().required("Quantity is required");
            },
            "data.sku_code": function (value = null) {
                return Validator.value(value).required("SKU Code is required");
            },
            "data.barcode": function (value = null) {
                return Validator.value(value).required("Barcode Code is required");
            },
            "data.rating": function (value = null) {
                return Validator.value(value).maxLength(1).required("Rating Code is required");
            },
            "data.status": function (value = null) {
                return Validator.value(value).required("Status is required");
            },
            "data.sorting": function (value = null) {
                return Validator.value(value).required("Sorting is required");
            },
            "data.discount_type": function (value = null) {
                return Validator.value(value).required("Discount type is required");
            },
            "data.discount_amount": function (value = null) {
                return Validator.value(value).required("Discount amount is required");
            },
            "data.vat_amount": function (value = null) {
                return Validator.value(value).required("Vat is required");
            },
            "data.tax_amount": function (value = null) {
                return Validator.value(value).required("Tax is required");
            },
        },
    };
</script>
<style lang="scss">
    .variant-input-field {
        width: 95%;
        border: 1px solid #4444;
        border-radius: 5px;
        padding: 8px 6px;
    }

    .variant-file-field {
        display: flex;
        align-items: center;

        img {
            height: 35px;
            width: 35px;
            border-radius: 50px;
            background: #4444;
            margin: 0 4px;
        }

        input {
            width: 93px;
        }
    }

    li.badge.b-form-tag {
        background: #e0e0e0;
        margin: 2px 2px;
        border-radius: 0px;

        span.b-form-tag-content {
            font-size: 12px;
            margin: 0 7px;
            color: #444;
        }

        button.close.b-form-tag-remove {
            font-size: 13px;
            border: 0;
            padding: 0;
            background: red;
            color: #fff;
            border-radius: 2px;
            height: 17px;
            width: 17px;
            text-align: center;
        }
    }

    label.image-dragable-box {
        width: 100%;
        height: 200px;
    }

    .preview-box {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        background: #f5f5f557;
        border: 1px dashed #4444;
        border-radius: 5px;
        cursor: pointer;

        img {
            height: 140px;
            width: 140px;
            object-fit: contain;
        }
    }

    .gallery_image {
        height: 100px;
        width: 100px;
        background: #f6f7fb;
        border-radius: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        position: relative;

        img.gallery_preview_image {
            height: 100%;
            width: 100%;
        }

        label.gellary-dragable-box {
            height: 100%;
            width: 100%;
            margin-top: 8px;
            border: 1px #8391a2 dashed;
            border-radius: 5px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 36px;
            color: #0acf97;
            cursor: pointer;
        }

        a.image-remove-button {
            position: absolute;
            background: #ff3838;
            height: 25px;
            width: 25px;
            text-align: center;
            padding: 4px;
            color: #fff;
            border-radius: 4px;
            right: 0;
            top: 0;
            margin: 6px;
        }
    }

    .action-button {
        width: 25px;
        padding: 0px 0;
        height: 27px;

        a {
            height: 26px;
            width: 26px;
            padding: 4px;
            border-radius: 50px;
        }
    }

    .similar-product-selector {
        min-height: unset;
        height: 28px;

        div#tags-with-dropdown {
            padding: 0;
            border: 0;
        }

        button.btn-outline-light {
            text-align: left;
            display: block;
            width: 100%;
            padding: 0.5rem 0.9rem;
            font-size: .8125rem;
            font-weight: 400;
            line-height: 1.5;
            color: var(--vz-body-color);
            background-color: var(--vz-input-bg);
            background-clip: padding-box;
            border: 1px solid var(--vz-input-border);
        }

        ul.dropdown-menu {
            box-shadow: 0px 4px 6px #4444;
            padding: 10px;
            border: 1px solid #3f51b5 !important;
            max-height: 298px !important;
            overflow-y: auto;
            transform: translate3d(0px, 38px, 0px) !important;
        }

        ul.selected-product {
            margin-top: 5px;
            margin-bottom: 0 !important;

            li {
                padding: 4px;
            }
        }

        button.close.b-form-tag-remove {
            color: #fff !important;
        }

        button.dropdown-item {
            color: #000 !important;
            white-space: normal;
        }
    }
</style>
