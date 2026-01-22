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
import Typography from "@mui/material/Typography";
import Box from "@mui/material/Box";

function sidenavLogoLabel(theme, { miniSidenav }) {
  const { typography, transitions } = theme;
  const { fontWeightMedium } = typography;

  return {
    ml: 0.5,
    fontWeight: fontWeightMedium,
    transition: transitions.create("width", {
      easing: transitions.easing.sharp,
      duration: transitions.duration.standard,
    }),
    ...(miniSidenav && {
      opacity: 0,
      width: 0,
      overflow: "hidden",
    }),
  };
}

export default sidenavLogoLabel;

