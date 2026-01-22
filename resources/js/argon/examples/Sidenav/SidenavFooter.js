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
import Button from "@mui/material/Button";
import Box from "@mui/material/Box";
import Typography from "@mui/material/Typography";
import Icon from "@mui/material/Icon";

function SidenavFooter() {
  return (
    <Box p={2} borderRadius="lg" bgColor="primary" color="white">
      <Typography variant="button" fontWeight="bold">
        Upgrade ke Pro
      </Typography>
      <Typography variant="caption" color="white" sx={{ display: "block", mt: 0.5 }}>
        Dapatkan akses ke fitur premium
      </Typography>
      <Button
        variant="contained"
        color="white"
        size="small"
        fullWidth
        sx={{ mt: 2, boxShadow: "none" }}
      >
        Upgrade Sekarang
      </Button>
    </Box>
  );
}

export default SidenavFooter;

