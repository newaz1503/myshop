<template>
  <div class="row mx-0" v-if="$parent.table.meta">
    <div class="col px-0">
      <div role="status" aria-live="polite">
        Showing {{ $parent.table.meta.from }} to {{ $parent.table.meta.to }} of
        {{ $parent.table.meta.total }} entries
      </div>
    </div>
    <div class="col p-0">
      <nav aria-label="Page navigation example">
        <ul class="pagination pagination-sm justify-content-end">
          <li class="page-item">
            <a
              class="page-link"
              v-on:click="get_datas(1)"
              aria-label="Previous"
            >
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <li class="page-item" v-if="$parent.table.meta.current_page > 5">
            <a
              class="page-link"
              v-on:click="get_datas($parent.table.meta.current_page - 5)"
              >{{ $parent.table.meta.current_page - 5 }}</a
            >
          </li>
          <li class="page-item" v-if="$parent.table.meta.current_page > 4">
            <a
              class="page-link"
              v-on:click="get_datas($parent.table.meta.current_page - 4)"
              >{{ $parent.table.meta.current_page - 4 }}</a
            >
          </li>
          <li class="page-item" v-if="$parent.table.meta.current_page > 3">
            <a
              class="page-link"
              v-on:click="get_datas($parent.table.meta.current_page - 3)"
              >{{ $parent.table.meta.current_page - 3 }}</a
            >
          </li>
          <li class="page-item" v-if="$parent.table.meta.current_page > 2">
            <a
              class="page-link"
              v-on:click="get_datas($parent.table.meta.current_page - 2)"
              >{{ $parent.table.meta.current_page - 2 }}</a
            >
          </li>
          <li class="page-item" v-if="$parent.table.meta.current_page > 1">
            <a
              class="page-link"
              v-on:click="get_datas($parent.table.meta.current_page - 1)"
              >{{ $parent.table.meta.current_page - 1 }}</a
            >
          </li>
          <li class="page-item active">
            <a
              class="page-link"
              v-on:click="get_datas($parent.table.meta.current_page)"
              >{{ $parent.table.meta.current_page }}</a
            >
          </li>
          <li
            class="page-item"
            v-if="
              $parent.table.meta.current_page < $parent.table.meta.last_page
            "
          >
            <a
              class="page-link"
              v-on:click="get_datas($parent.table.meta.current_page + 1)"
              >{{ $parent.table.meta.current_page + 1 }}</a
            >
          </li>
          <li
            class="page-item"
            v-if="
              $parent.table.meta.current_page + 1 < $parent.table.meta.last_page
            "
          >
            <a
              class="page-link"
              v-on:click="get_datas($parent.table.meta.current_page + 2)"
              >{{ $parent.table.meta.current_page + 2 }}</a
            >
          </li>
          <li
            class="page-item"
            v-if="
              $parent.table.meta.current_page + 2 < $parent.table.meta.last_page
            "
          >
            <a
              class="page-link"
              v-on:click="get_datas($parent.table.meta.current_page + 3)"
              >{{ $parent.table.meta.current_page + 3 }}</a
            >
          </li>
          <li
            class="page-item"
            v-if="
              $parent.table.meta.current_page + 3 < $parent.table.meta.last_page
            "
          >
            <a
              class="page-link"
              v-on:click="get_datas($parent.table.meta.current_page + 4)"
              >{{ $parent.table.meta.current_page + 4 }}</a
            >
          </li>
          <li
            class="page-item"
            v-if="
              $parent.table.meta.current_page + 4 < $parent.table.meta.last_page
            "
          >
            <a
              class="page-link"
              v-on:click="get_datas($parent.table.meta.current_page + 5)"
              >{{ $parent.table.meta.current_page + 5 }}</a
            >
          </li>
          <li
            class="page-item"
            v-if="
              $parent.table.meta.current_page + 5 <
                $parent.table.meta.last_page &&
              $parent.table.meta.current_page + 6 < 12
            "
          >
            <a
              class="page-link"
              v-on:click="get_datas($parent.table.meta.current_page + 6)"
              >{{ $parent.table.meta.current_page + 6 }}</a
            >
          </li>
          <li
            class="page-item"
            v-if="
              $parent.table.meta.current_page + 6 <
                $parent.table.meta.last_page &&
              $parent.table.meta.current_page + 7 < 12
            "
          >
            <a
              class="page-link"
              v-on:click="get_datas($parent.table.meta.current_page + 7)"
              >{{ $parent.table.meta.current_page + 7 }}</a
            >
          </li>
          <li
            class="page-item"
            v-if="
              $parent.table.meta.current_page + 7 <
                $parent.table.meta.last_page &&
              $parent.table.meta.current_page + 8 < 12
            "
          >
            <a
              class="page-link"
              v-on:click="get_datas($parent.table.meta.current_page + 8)"
              >{{ $parent.table.meta.current_page + 8 }}</a
            >
          </li>
          <li
            class="page-item"
            v-if="
              $parent.table.meta.current_page + 8 <
                $parent.table.meta.last_page &&
              $parent.table.meta.current_page + 9 < 12
            "
          >
            <a
              class="page-link"
              v-on:click="get_datas($parent.table.meta.current_page + 9)"
              >{{ $parent.table.meta.current_page + 9 }}</a
            >
          </li>
          <li
            class="page-item"
            v-if="
              $parent.table.meta.current_page + 9 <
                $parent.table.meta.last_page &&
              $parent.table.meta.current_page + 10 < 12
            "
          >
            <a
              class="page-link"
              v-on:click="get_datas($parent.table.meta.current_page + 10)"
              >{{ $parent.table.meta.current_page + 10 }}</a
            >
          </li>
          <li class="page-item">
            <a
              class="page-link"
              v-on:click="get_datas($parent.table.meta.last_page)"
              aria-label="Next"
            >
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>

<script>
export default {
  name: "Pagination",
  props: ["url","routeName", "search_data", "scrollNone"],
  methods: {
    get_datas: function (page_index) {
      this.$router.push({ name: this.routeName, query: { page: page_index } })
      this.$root.pageNumber = page_index;
      this.$route.query.id = '';
      this.scrollTop(0, 90);
      this.$root.tableSpinner = true;
      let url = this.url;
      if (this.$root.pageNumber > 0) {
        url = this.url + "?page=" + this.$root.pageNumber;
      }
      axios
        .get("/" + url, { params: this.search_data })
        .then((res) => {
          this.$parent.table.datas = res.data.data;
          this.$parent.table.meta = res.data.meta;
          this.$parent.table.links = res.data.links;
        })
        .catch((error) => console.log(error))
        .then((alw) =>
          setTimeout(() => (this.$root.tableSpinner = false), 200)
        );
    },
  },
};
</script>
