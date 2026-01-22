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

// react-router-dom components
import { useLocation } from "react-router-dom";

// prop-types is a library for typechecking of props
import PropTypes from "prop-types";

// @mui material components
import Box from "@mui/material/Box";
import IconButton from "@mui/material/IconButton";
import Icon from "@mui/material/Icon";

// Argon Dashboard 2 MUI components
import ArgonBox from "components/ArgonBox";
import ArgonTypography from "components/ArgonTypography";

// Argon Dashboard 2 MUI context
import { useArgonController, setMiniSidenav } from "context";

const item = (theme, { active }) => {
  const { palette, transitions, breakpoints } = theme;
  const { grey, white, primary } = palette;
  const { xxl } = boxShadows;

  return {
    background: active ? white.main : "transparent",
    color: active ? primary.main : grey[600],
    display: "flex",
    alignItems: "center",
    justifyContent: "flex-start",
    minHeight: "48px",
    pl: 2.5,
    pr: 2.5,
    py: 1.25,
    borderRadius: "8px",
    cursor: "pointer",
    transition: transitions.create("background-color", {
      easing: transitions.easing.sharp,
      duration: transitions.duration.short,
    }),
    "&:hover": {
      backgroundColor: active ? white.main : grey[100],
    },
    [breakpoints.up("xl")]: {
      minHeight: "48px",
      py: 1.25,
      pr: 2.5,
      pl: 2.5,
    },
  };
};

const icon = (theme, { active, darkSidenav }) => {
  const { palette, transitions } = theme;
  const { grey, white, primary } = palette;

  return {
    color: active ? primary.main : darkSidenav ? white.main : grey[500],
    transition: transitions.create("color", {
      easing: transitions.easing.sharp,
      duration: transitions.duration.short,
    }),
  };
};

function SidenavItem({ icon, name, active, noCollapse }) {
  const [controller] = useArgonController();
  const { miniSidenav, darkSidenav } = controller;

  return (
    <ListItem component="li">
      <ArgonBox
        component={NavLink}
        to="#"
        sx={(theme) => item(theme, { active, miniSidenav })}
      >
        <ListItemIcon sx={({ palette }) => icon(theme, { active, darkSidenav })}>
          {icon}
        </ListItemIcon>
        <ListItemText
          primary={
            <ArgonTypography
              variant="button"
              fontWeight={active ? "bold" : "regular"}
              color={active ? "primary" : "text"}
              sx={{ textTransform: "none" }}
            >
              {name}
            </ArgonTypography>
          }
        />
      </ArgonBox>
    </ListItem>
  );
}

// Setting default values for the props of SidenavItem
SidenavItem.defaultProps = {
  icon: <Icon>circle</Icon>,
  active: false,
  noCollapse: false,
};

// Typechecking props for the SidenavItem
SidenavItem.propTypes = {
  icon: PropTypes.node,
  name: PropTypes.string.isRequired,
  active: PropTypes.bool,
  noCollapse: PropTypes.bool,
};

export default SidenavItem;

