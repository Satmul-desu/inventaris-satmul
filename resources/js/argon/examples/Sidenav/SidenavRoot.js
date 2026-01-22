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
import Drawer from "@mui/material/Drawer";
import { styled } from "@mui/material/styles";

export default styled(Drawer)(({ theme, ownerState }) => {
  const { palette, boxShadows, transitions, breakpoints, functions } = theme;
  const { darkSidenav, miniSidenav, layout } = ownerState;

  const { white, background, dark } = palette;
  const { xxl } = boxShadows;
  const { pxToRem, linearGradient } = functions;

  const sidebarWidth = 250;
  const sidebarWidthMini = 120;

  // styles for the sidenav when it's mini
  const drawerMiniStyles = () => ({
    "& .MuiDrawer-paper": {
      boxShadow: xxl,
      background: linearGradient(darkSidenav ? dark.main : white.main, darkSidenav ? dark.main : white.main),
      width: sidebarWidthMini,
      transition: transitions.create("width", {
        easing: transitions.easing.sharp,
        duration: transitions.duration.standard,
      }),
      [breakpoints.up("xl")]: {
        width: sidebarWidthMini,
      },
    },
  });

  // styles for the sidenav when it's open
  const drawerOpenStyles = () => ({
    "& .MuiDrawer-paper": {
      boxShadow: xxl,
      background: linearGradient(darkSidenav ? dark.main : white.main, darkSidenav ? dark.main : white.main),
      borderRight: "none",
      width: sidebarWidth,
      transition: transitions.create("width", {
        easing: transitions.easing.sharp,
        duration: transitions.duration.standard,
      }),
      [breakpoints.up("xl")]: {
        width: sidebarWidth,
      },
    },
  });

  // styles for the sidenav when it's closed
  const drawerCloseStyles = () => ({
    "& .MuiDrawer-paper": {
      boxShadow: xxl,
      background: linearGradient(darkSidenav ? dark.main : white.main, darkSidenav ? dark.main : white.main),
      width: sidebarWidthMini,
      transition: transitions.create("width", {
        easing: transitions.easing.sharp,
        duration: transitions.duration.standard,
      }),
      [breakpoints.up("xl")]: {
        width: sidebarWidthMini,
      },
    },
  });

  return {
    "& .MuiDrawer-paper": {
      boxShadow: xxl,
      width: sidebarWidth,
    },
    ...(miniSidenav ? drawerMiniStyles() : drawerOpenStyles()),
    ...(miniSidenav && !darkSidenav ? drawerCloseStyles() : {}),
  };
});

