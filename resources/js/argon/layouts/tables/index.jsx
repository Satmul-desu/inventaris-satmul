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
import Card from "@mui/material/Card";
import Icon from "@mui/material/Icon";

// Argon Dashboard 2 MUI components
import ArgonBox from "components/ArgonBox";
import ArgonTypography from "components/ArgonTypography";
import ArgonButton from "components/ArgonButton";

// Argon Dashboard 2 MUI example components
import DashboardLayout from "examples/LayoutContainers/DashboardLayout";
import DashboardNavbar from "examples/Navbars/DashboardNavbar";
import Footer from "examples/Footer";
import DataTable from "examples/Tables/DataTable";

function Tables() {
  return (
    <DashboardLayout>
      <DashboardNavbar />
      <ArgonBox py={3}>
        <ArgonBox mb={3}>
          <Grid container justifyContent="space-between" alignItems="center">
            <Grid item xs={12} md={6}>
              <ArgonTypography variant="h4" fontWeight="bold">
                Data Barang
              </ArgonTypography>
              <ArgonTypography variant="body2" color="text">
                Kelola semua data barang inventaris di sini
              </ArgonTypography>
            </Grid>
            <Grid item xs={12} md={6} sx={{ textAlign: "right" }}>
              <ArgonButton color="primary" variant="gradient">
                <Icon>add</Icon>&nbsp; Tambah Barang
              </ArgonButton>
            </Grid>
          </Grid>
        </ArgonBox>
        <Card>
          <ArgonBox p={3}>
            <ArgonTypography variant="h6" fontWeight="bold">
              Daftar Barang Inventaris
            </ArgonTypography>
          </ArgonBox>
          <ArgonBox p={3} pt={0}>
            <ArgonTypography variant="body2" color="text">
              Data barang akan ditampilkan di sini. Silakan hubungkan dengan database untuk menampilkan data.
            </ArgonTypography>
          </ArgonBox>
        </Card>
      </ArgonBox>
      <Footer />
    </DashboardLayout>
  );
}

export default Tables;

