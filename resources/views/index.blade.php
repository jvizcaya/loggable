<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="base-url" content="{{ url(config('loggable.route_path')) }}">
    <link href="{{ asset('vendor/loggable/app.css') }}" rel="stylesheet">
    <title>Loggable - Dashboard</title>
  </head>
  <body>
    <div id="app">
      <modal :show="showModal" @close="showModal=false" :content="modalContent"></modal>
      <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Loggable Dashboard</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
            <form class="d-flex">
              <button class="btn btn-primary" @click.prevent="fetchData(1)">Refresh</button>
            </form>
          </div>
        </div>
      </nav>
      <div class="container">
        <div class="row">
          <div class="col">
            <Multiselect
                v-model="params.user"
                :options="users"
                :searchable="true"
                :internal-search="false"
                :clear-on-select="false"
                :close-on-select="true"
                :options-limit="300"
                :limit="5"
                placeholder="User"
                @search-change="fetchUsers">
            </Multiselect>
          </div>
          <div class="col">
            <Multiselect
                v-model="params.table"
                :options="tables"
                :internal-search="false"
                :clear-on-select="false"
                :close-on-select="true"
                placeholder="Table">
            </Multiselect>
          </div>
          <div class="col">
            <Multiselect
                v-model="params.model"
                :options="models"
                :searchable="true"
                :internal-search="false"
                :clear-on-select="false"
                :close-on-select="true"
                :options-limit="300"
                :limit="5"
                placeholder="Model ID"
                @search-change="fetchModels">
            </Multiselect>
          </div>
          <div class="col">
            <Datepicker v-model="params.date"
                       :format="'MM/dd/yyyy'"
                       :enable-Time-Picker=false
                       placeholder="Date"
                       auto-Apply />
          </div>
        </div>
      </div>
      <div class="container" v-cloak>
        <div class="card-body p-0">
          <div class="table-responsive-sm">
            <table v-if="logs.length" class="table table-sm table-hover table-striped table-borderless caption-top">
              <caption>List of logs</caption>
              <thead class="table-dark">
                <tr>
                  <th class="text-center">User ID</th>
                  <th>User</th>
                  <th>Model</th>
                  <th>Model Id</th>
                  <th>Date</th>
                  <th>Type</th>
                </tr>
              </thead>
              <tr class="fs-6" v-for="log in logs" :key="log.id">
                <th class="text-center">@{{ log.user_id }}</th>
                <td>@{{ log.payload.user.name }} (@{{ log.payload.user.email }})</td>
                <td>@{{ log.model_type }} (@{{ log.table }})</td>
                <td>@{{ log.model_id }}</td>
                <td>@{{ log.log_at }}</td>
                <td @click.prevent="showData(log.payload.data,log.type)">
                  <span class="badge p-2" :class="{'bg-success': log.type == 'create', 'bg-info': log.type == 'update', 'bg-danger': log.type == 'delete' }" >
                    @{{ log.type }}
                  </span>
                </td>
              </tr>
            </table>
            <p class="text-center font-weight-bold mt-4" v-else>No results to show</p>
          </div>
        </div>
        <div class="card-footers" v-if="logs.length">
          <div class="row">
            <div class="col">
              <span class="text-muted text-right">Showing <strong>@{{ pagination.to }}</strong> of <strong>@{{ pagination.total }}</strong> total</span>
            </div>
            <div class="col text-right">
              <pagination-links :pagination="pagination" @update="fetchData($event)"></pagination-links>
            </div>
          </div>
        </div>
      </div>
      <vue-progress-bar></vue-progress-bar>
    </div>
    <script src="{{ asset('vendor/loggable/app.js') }}"></script>
  </body>
</html>
