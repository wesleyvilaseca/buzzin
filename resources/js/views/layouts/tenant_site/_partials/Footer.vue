<template>
  <!-- Remove the container if you want to extend the Footer to full width. -->
  <div class="mt-5">
    <!-- Footer -->
    <footer class="text-center text-lg-start text-dark pt-2 " style="background-color: #ECEFF1">
      <!-- <section class="d-flex justify-content-between p-4 text-white" style="background-color: #21D192">
        <div class="me-5">
          <span>Get connected with us on social networks:</span>
        </div>

        <div>
          <a href="" class="text-white me-4">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="" class="text-white me-4">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="" class="text-white me-4">
            <i class="fab fa-google"></i>
          </a>
          <a href="" class="text-white me-4">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="" class="text-white me-4">
            <i class="fab fa-linkedin"></i>
          </a>
          <a href="" class="text-white me-4">
            <i class="fab fa-github"></i>
          </a>
        </div>
      </section> -->

      <!-- Section: Links  -->
      <section class="">
        <div class="container text-center text-md-start mt-5">
          <!-- Grid row -->
          <div class="row mt-3">
            <!-- Grid column -->
            <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
              <!-- Content -->
              <h6 class="text-center text-capitalize fw-bold title-section-footer">{{ company.name }}</h6>
              <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px" />

              <p class="text-center">Homless animal shelter The budgetary unit of the Capital City of Warsaw</p>

              <ul class="list-unstyled d-flex flex-row justify-content-center social-footer-links">
                <li>
                  <a class="text-white px-2" href="#!">
                    <i class="fab fa-facebook-square"></i>
                  </a>
                </li>
                <li>
                  <a class="text-white px-2" href="#!">
                    <i class="fab fa-instagram"></i>
                  </a>
                </li>
                <li>
                  <a class="text-white ps-2" href="#!">
                    <i class="fab fa-youtube"></i>
                  </a>
                </li>
              </ul>
            </div>
            <!-- Grid column -->

            <div class="col-md-4 col-lg-3 col-xl-4 mx-auto mb-md-0 mb-4">
              <h6 class="text-center text-capitalize fw-bold title-section-footer">Contato</h6>
              <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px" />
              <p><i class="fas fa-home mr-3"></i> {{ company.address }}
                <span v-if="company.number">nº {{ company.number }}</span> {{ company.district }} , {{ company.city }} -
                {{ company.state }}
              </p>
              <p><i class="fas fa-envelope mr-3"></i> {{ company.email }}</p>
              <p v-if="company.mobile_phone"><i class="fas fa-phone mr-3"></i> {{ company.mobile_phone }}</p>
            </div>

            <div class="col-lg-4 col-md-6 mb-4 mb-md-0" v-if="company?.operationDays?.length > 0">
              <h6 class="text-center text-capitalize fw-bold title-section-footer">Funcionamento</h6>
              <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px" />
              <table class="table text-center">
                <tbody class="font-weight-normal">
                  <template v-for="(item, index) in company.operationDays" :key="index">
                    <tr>
                      <td>{{ item.description }}</td>
                      <td>
                        <tr v-for="(item, index) in item?.time" :key="index">
                          <td>
                            <strong>
                              {{ item.time_ini }} - {{ item.time_end }}
                            </strong>
                          </td>
                        </tr>
                    </td>
                    </tr>
                  </template>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </section>
      <!-- Section: Links  -->

      <!-- Copyright -->
      <div class="text-center p-3" style="background-color: #000; color: #fff">
        © 2023 Copyright:
        <a class="text-light" href="https://buzzin.com.br/">Buzzin.com.br</a>
      </div>
      <!-- Copyright -->
    </footer>
    <!-- Footer -->
  </div>
  <!-- End of .container -->
</template>
<style scoped>
element.style {
  padding: 10px 0;
}

.border-footer hr {
  color: antiquewhite;
}

.title-section-footer {
  color: v-bind("paleta.links") !important;
}

.social-footer-links li a {
  color: v-bind("paleta.links") !important;
}

.social-footer-links li a:hover {
  color: v-bind("paleta.links_hover") !important;
}
</style>

  
<script>
import ModalComponent from "../../../../components/widgets/ModalComponent.vue";
import { mapState } from "vuex";

export default {
  components: {
    ModalComponent
  },
  data() {
    return {};
  },
  computed: {
    ...mapState({
      company: (state) => state.tenant.company,
      paleta: (state) => state.layout.paleta,
    })
  },
  methods: {},
  watch: {},
};
</script>