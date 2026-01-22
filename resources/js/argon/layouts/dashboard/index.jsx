/**
=========================================================
* Argon Dashboard 2 MUI - v3.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-material-ui
* Copyright 2023 Creative Tim (https://www.creative-tim.com)

Coded by www.creative-tim.com

 =========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
*/

// @mui material components
import Grid from "@mui/material/Grid";
import Icon from "@mui/material/Icon";

// Argon Dashboard 2 MUI components
import ArgonBox from "components/ArgonBox";
import ArgonTypography from "components/ArgonTypography";

// Argon Dashboard 2 MUI example components
import DashboardLayout from "examples/LayoutContainers/DashboardLayout";
import DashboardNavbar from "examples/Navbars/DashboardNavbar";
import Footer from "examples/Footer";

// Dashboard layout components
import ComplexStatisticsCard from "examples/Cards/StatisticsCards/ComplexStatisticsCard";

function Dashboard() {
  return (
    <DashboardLayout>
      <DashboardNavbar />
      <ArgonBox py={3}>
        <Grid container spacing={3} mb={3}>
          <Grid item xs={12} md={6} lg={3}>
            <ComplexStatisticsCard
              title="Total Barang"
              count="1,250"
              icon={{ color: "info", component: <Icon fontSize="inherit">inventory_2</Icon> }}
              percentage={{ color: "success", count: "+5%", text: "dari bulan lalu" }}
            />
          </Grid>
          <Grid item xs={12} md={6} lg={3}>
            <ComplexStatisticsCard
              title="Barang Tersedia"
              count="892"
              icon={{ color: "success", component: <Icon fontSize="inherit">check_circle</Icon> }}
              percentage={{ color: "success", count: "+12%", text: "dari minggu lalu" }}
            />
          </Grid>
          <Grid item xs={12} md={6} lg={3}>
            <ComplexStatisticsCard
              title="Barang Dipinjam"
              count="245"
              icon={{ color: "warning", component: <Icon fontSize="inherit">swap_horiz</Icon> }}
              percentage={{ color: "error", count: "-3%", text: "dari minggu lalu" }}
            />
          </Grid>
          <Grid item xs={12} md={6} lg={3}>
            <ComplexStatisticsCard
              title="Barang Rusak"
              count="113"
              icon={{ color: "error", component: <Icon fontSize="inherit">warning</Icon> }}
              percentage={{ color: "error", count: "+2%", text: "needs attention" }}
            />
          </Grid>
        </Grid>
        <Grid container spacing={3}>
          <Grid item xs={12} lg={8}>
            <ArgonBox
              sx={{
                background: "linear-gradient(81.62deg, #5e72e4 2.25%, #825ee4 100.2%)",
                borderRadius: "12px",
                p: 3,
                color: "white",
              }}
            >
              <ArgonTypography variant="h4" fontWeight="bold" mb={1}>
                Selamat Datang!
              </ArgonTypography>
              <ArgonTypography variant="body1" opacity={0.9}>
                Sistem Inventaris Barang Satmul siap membantu Anda mengelola
                inventaris dengan lebih efisien.
              </ArgonTypography>
            </ArgonBox>
          </Grid>
          <Grid item xs={12} lg={4}>
            <ArgonBox
              sx={{
                background: "linear-gradient(81.62deg, #2dce89 2.25%, #2dcecc 100.2%)",
                borderRadius: "12px",
                p: 3,
                color: "white",
              }}
            >
              <ArgonTypography variant="h5" fontWeight="bold" mb={2}>
                Quick Actions
              </ArgonTypography>
              <ArgonBox display="flex" flexDirection="column" gap={1}>
                <ArgonTypography variant="body2" sx={{ display: "flex", alignItems: "center", gap: 1 }}>
                  <Icon fontSize="small">add</Icon> Tambah Barang Baru
                </ArgonTypography>
                <ArgonTypography variant="body2" sx={{ display: "flex", alignItems: "center", gap: 1 }}>
                  <Icon fontSize="small">search</Icon> Cari Barang
                </ArgonTypography>
                <ArgonTypography variant="body2" sx={{ display: "flex", alignItems: "center", gap: 1 }}>
                  <Icon fontSize="small">print</Icon> Cetak Laporan
                </ArgonTypography>
              </ArgonBox>
            </ArgonBox>
          </Grid>
        </Grid>
      </ArgonBox>
      <Footer />
    </DashboardLayout>
  );
}

export default Dashboard;

