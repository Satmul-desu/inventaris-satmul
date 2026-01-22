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

// prop-types is a library for typechecking of props
import PropTypes from "prop-types";

// @mui material components
import ListItem from "@mui/material/ListItem";
import ListItemIcon from "@mui/material/ListItemIcon";
import ListItemText from "@mui/material/ListItemText";
import Icon from "@mui/material/Icon";

// Argon Dashboard 2 MUI components
import ArgonBox from "components/ArgonBox";
import ArgonTypography from "components/ArgonTypography";

function NotificationItem({ icon, title, date, onClick }) {
  return (
    <ListItem component="li" onClick={onClick} sx={{ cursor: "pointer" }}>
      <ArgonBox
        display="flex"
        alignItems="center"
        p={1}
        sx={{
          background: "linear-gradient(81.62deg, #5e72e4 2.25%, #825ee4 100.2%)",
          borderRadius: "8px",
          mr: 2,
        }}
      >
        <Icon sx={{ color: "white" }}>{icon}</Icon>
      </ArgonBox>
      <ArgonBox>
        <ArgonTypography variant="button" fontWeight="medium">
          {title}
        </ArgonTypography>
        <ArgonTypography
          variant="caption"
          color="text"
          fontWeight="regular"
          sx={{ display: "block", mt: 0.5 }}
        >
          {date}
        </ArgonTypography>
      </ArgonBox>
    </ListItem>
  );
}

// Setting default values for the props of NotificationItem
NotificationItem.defaultProps = {
  icon: "notifications",
  onClick: () => {},
};

// Typechecking props for the NotificationItem
NotificationItem.propTypes = {
  icon: PropTypes.node,
  title: PropTypes.string.isRequired,
  date: PropTypes.string.isRequired,
  onClick: PropTypes.func,
};

export default NotificationItem;

