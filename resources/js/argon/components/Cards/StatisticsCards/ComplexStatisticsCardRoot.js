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
import Card from "@mui/material/Card";
import Box from "@mui/material/Box";
import Typography from "@mui/material/Typography";
import Icon from "@mui/material/Icon";

// Argon Dashboard 2 MUI components
import ArgonBox from "components/ArgonBox";
import ArgonTypography from "components/ArgonTypography";
import ArgonButton from "components/ArgonButton";

// Custom styles for ComplexStatisticsCard
import { card, cardContent, cardIconBox, cardIcon } from "./styles";

function ComplexStatisticsCard({ color, title, count, percentage, icon }) {
  return (
    <Card sx={card}>
      <Box sx={cardContent}>
        <Box sx={cardIconBox}>
          <Icon sx={cardIcon}>{icon}</Icon>
        </Box>
        <ArgonBox sx={{ mt: 2 }}>
          <ArgonTypography variant="button" color="text" fontWeight="regular">
            {title}
          </ArgonTypography>
          <ArgonTypography variant="h3" fontWeight="bold">
            {count}
          </ArgonTypography>
        </ArgonBox>
        {percentage && (
          <ArgonBox display="flex" alignItems="center" mt={1}>
            <ArgonTypography
              variant="button"
              color={percentage.color}
              fontWeight="bold"
              sx={{ display: "flex", alignItems: "center" }}
            >
              {typeof percentage.count === "number" 
                ? (percentage.count > 0 ? "+" : "") + percentage.count + "%"
                : percentage.count}
              <Icon sx={{ fontSize: "1rem", ml: 0.5 }}>
                {percentage.count.toString().includes("+") || (typeof percentage.count === "number" && percentage.count > 0) 
                  ? "arrow_upward" 
                  : "arrow_downward"}
              </Icon>
            </ArgonTypography>
            <ArgonTypography variant="caption" color="text" ml={1}>
              {percentage.text}
            </ArgonTypography>
          </ArgonBox>
        )}
      </Box>
    </Card>
  );
}

export default ComplexStatisticsCard;

