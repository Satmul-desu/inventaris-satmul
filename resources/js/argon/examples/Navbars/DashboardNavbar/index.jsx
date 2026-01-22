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

import { useState, useEffect } from "react";

// react-router components
import { useLocation } from "react-router-dom";

// prop-types is a library for typechecking of props
import PropTypes from "prop-types";

// @mui material components
import AppBar from "@mui/material/AppBar";
import Toolbar from "@mui/material/Toolbar";
import IconButton from "@mui/material/IconButton";
import Menu from "@mui/material/Menu";
import MenuItem from "@mui/material/MenuItem";
import Icon from "@mui/material/Icon";

// Argon Dashboard 2 MUI components
import ArgonBox from "components/ArgonBox";
import ArgonTypography from "components/ArgonTypography";
import ArgonInput from "components/ArgonInput";

// Argon Dashboard 2 MUI example components
import NotificationItem from "examples/Items/NotificationItem";

// Custom styles for the DashboardNavbar
import { navbar, navbarContainer, navbarRow } from "examples/Navbars/DashboardNavbar/styles";

// Argon Dashboard 2 MUI context
import { useArgonController, setTransparentNavbar, setMiniSidenav } from "context";

function DashboardNavbar({ absolute, light, isMini }) {
  const [controller, dispatch] = useArgonController();
  const { miniSidenav, transparentNavbar, fixedNavbar, openConfigurator } = controller;
  const [menu, setMenu] = useState(null);
  const [notification, setNotification] = useState(null);
  const { pathname } = useLocation();

  useEffect(() => {
    setTransparentNavbar(dispatch, fixedNavbar ? false : true);
  }, [dispatch, fixedNavbar, pathname]);

  const handleMiniSidenav = () => setMiniSidenav(dispatch, !miniSidenav);
  const handleConfiguratorOpen = () => openConfigurator
    ? dispatch({ type: "OPEN_CONFIGURATOR", value: !openConfigurator })
    : dispatch({ type: "OPEN_CONFIGURATOR", value: true });
  const handleOpenMenu = (event) => setMenu(event.currentTarget);
  const handleOpenNotification = (event) => setNotification(event.currentTarget);
  const handleCloseMenu = () => setMenu(null);
  const handleCloseNotification = () => setNotification(null);

  // Styles for the navbar icons
  const iconsStyle = ({ palette: { white, grey } }) => ({
    color: light ? white.main : grey[600],
  });

  // Get page title from pathname
  const getPageTitle = () => {
    const segments = pathname.split("/").filter(Boolean);
    return segments.length > 0 
      ? segments[segments.length - 1].charAt(0).toUpperCase() + segments[segments.length - 1].slice(1)
      : "Dashboard";
  };

  return (
    <AppBar
      position={absolute ? "absolute" : fixedNavbar ? "fixed" : "absolute"}
      color="inherit"
      sx={(theme) => navbar(theme, { transparentNavbar, absolute, light })}
    >
      <Toolbar sx={(theme) => navbarContainer(theme)}>
        <ArgonBox color="inherit" sx={{ width: "100%" }} md={{ display: "flex" }}>
          <ArgonBox sx={{ display: "flex", alignItems: "center" }}>
            <ArgonTypography variant="h6" fontWeight="bold" color="dark">
              {getPageTitle()}
            </ArgonTypography>
          </ArgonBox>
          <ArgonBox sx={(theme) => navbarRow(theme, { isMini })}>
            <ArgonBox pr={1}>
              <ArgonInput
                placeholder="Cari..."
                startAdornment={
                  <Icon sx={{ color: grey[500] }}>search</Icon>
                }
              />
            </ArgonBox>
            <ArgonBox color={light ? "white" : "inherit"}>
              <IconButton
                onClick={handleConfiguratorOpen}
                sx={iconsStyle}
              >
                <Icon>settings</Icon>
              </IconButton>
              <IconButton
                size="small"
                sx={iconsStyle}
                onClick={handleMiniSidenav}
              >
                <Icon>
                  {miniSidenav ? "menu_open" : "menu"}
                </Icon>
              </IconButton>
              <IconButton
                sx={iconsStyle}
                onClick={handleOpenNotification}
              >
                <Icon>notifications</Icon>
              </IconButton>
              <Menu
                anchorEl={notification}
                open={Boolean(notification)}
                onClose={handleCloseNotification}
              >
                <NotificationItem
                  image={<Icon>email</Icon>}
                  title="Pesan baru"
                  date="3 menit yang lalu"
                  onClick={handleCloseNotification}
                />
                <NotificationItem
                  image={<Icon>podcasts</Icon>}
                  title="Episode podcast baru"
                  date="4 jam yang lalu"
                  onClick={handleCloseNotification}
                />
              </Menu>
              <IconButton
                sx={iconsStyle}
                onClick={handleOpenMenu}
                color="inherit"
              >
                <Icon>account_circle</Icon>
              </IconButton>
              <Menu
                anchorEl={menu}
                open={Boolean(menu)}
                onClose={handleCloseMenu}
              >
                <MenuItem onClick={handleCloseMenu}>Profil</MenuItem>
                <MenuItem onClick={handleCloseMenu}>Pengaturan</MenuItem>
                <MenuItem onClick={handleCloseMenu}>Keluar</MenuItem>
              </Menu>
            </ArgonBox>
          </ArgonBox>
        </ArgonBox>
      </Toolbar>
    </AppBar>
  );
}

// Setting default values for the props of DashboardNavbar
DashboardNavbar.defaultProps = {
  absolute: false,
  light: false,
  isMini: false,
};

// Typechecking props for the DashboardNavbar
DashboardNavbar.propTypes = {
  absolute: PropTypes.bool,
  light: PropTypes.bool,
  isMini: PropTypes.bool,
};

export default DashboardNavbar;

