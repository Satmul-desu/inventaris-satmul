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
import Avatar from "@mui/material/Avatar";

// Argon Dashboard 2 MUI components
import ArgonBox from "components/ArgonBox";
import ArgonTypography from "components/ArgonTypography";
import ArgonButton from "components/ArgonButton";

// Argon Dashboard 2 MUI example components
import DashboardLayout from "examples/LayoutContainers/DashboardLayout";
import DashboardNavbar from "examples/Navbars/DashboardNavbar";
import Footer from "examples/Footer";

function Profile() {
  return (
    <DashboardLayout>
      <DashboardNavbar />
      <ArgonBox py={3} mb={3}>
        <Grid container spacing={3} justifyContent="center">
          <Grid item xs={12} md={6} lg={4}>
            <Card sx={{ p: 3, textAlign: "center" }}>
              <ArgonBox display="flex" justifyContent="center" mb={3}>
                <Avatar
                  sx={{ width: 120, height: 120, bgcolor: "primary.main" }}
                  alt="User Avatar"
                >
                  A
                </Avatar>
              </ArgonBox>
              <ArgonTypography variant="h5" fontWeight="bold">
                Admin Satmul
              </ArgonTypography>
              <ArgonTypography variant="body2" color="text" mb={2}>
                Administrator
              </ArgonTypography>
              <ArgonButton color="primary" variant="gradient" fullWidth>
                Ubah Profil
              </ArgonButton>
            </Card>
          </Grid>
          <Grid item xs={12} md={6} lg={8}>
            <Card sx={{ p: 3 }}>
              <ArgonTypography variant="h6" fontWeight="bold" mb={3}>
                Informasi Profil
              </ArgonTypography>
              <Grid container spacing={3}>
                <Grid item xs={12} md={6}>
                  <ArgonTypography variant="body2" color="text" mb={1}>
                    Nama Lengkap
                  </ArgonTypography>
                  <ArgonTypography variant="body1" fontWeight="medium">
                    Admin Satmul
                  </ArgonTypography>
                </Grid>
                <Grid item xs={12} md={6}>
                  <ArgonTypography variant="body2" color="text" mb={1}>
                    Email
                  </ArgonTypography>
                  <ArgonTypography variant="body1" fontWeight="medium">
                    admin@satmul.com
                  </ArgonTypography>
                </Grid>
                <Grid item xs={12} md={6}>
                  <ArgonTypography variant="body2" color="text" mb={1}>
                    Jabatan
                  </ArgonTypography>
                  <ArgonTypography variant="body1" fontWeight="medium">
                    Administrator
                  </ArgonTypography>
                </Grid>
                <Grid item xs={12} md={6}>
                  <ArgonTypography variant="body2" color="text" mb={1}>
                    Terakhir Login
                  </ArgonTypography>
                  <ArgonTypography variant="body1" fontWeight="medium">
                    2024-01-15 10:30:00
                  </ArgonTypography>
                </Grid>
              </Grid>
            </Card>
          </Grid>
        </Grid>
      </ArgonBox>
      <Footer />
    </DashboardLayout>
  );
}

export default Profile;

