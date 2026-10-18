import React from "react";
import Slider from "react-slick";

import { IconBrandHipchat } from "@tabler/icons-react";
import {
  Badge,
  Button,
  Card,
  CardBody,
  CardFooter,
  CardHeader,
  Col,
  Dropdown,
  DropdownItem,
  DropdownMenu,
  DropdownToggle,
  Form,
  ListGroup,
  Progress,
  Row,
  Tooltip,
} from "reactstrap";
import {
  friends,
  posts,
  profileMessages,
  profileProjects,
  timelineData,
} from "@/Data/Apps/profileapp/ProfileAppData";
import { FilePond } from "react-filepond";
import { Heart } from "phosphor-react";
import { Send } from "iconoir-react";

interface FeaturedStoriesProps {
  data: string;
}

const FeaturedStories: React.FC<FeaturedStoriesProps> = ({ data }) => {
  const [dropdownOpen, setDropdownOpen] = React.useState<{
    [key: number]: boolean;
  }>({});
  const [tooltipOpen, setTooltipOpen] = React.useState<{
    [key: number]: boolean;
  }>({});

  const toggleDropdown = (id: number) => {
    setDropdownOpen((prev) => ({ ...prev, [id]: !prev[id] }));
  };

  const toggleTooltip = (id: number) => {
    setTooltipOpen((prev) => ({ ...prev, [id]: !prev[id] }));
  };

  const settings = {
    slidesToShow: 4,
    className: "story-container app-arrow",
    slidesToScroll: 1,
    autoplay: true,
    arrows: false,
    autoplaySpeed: 1000,
    responsive: [
      {
        breakpoint: 1366,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 3,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
        },
      },
    ],
  };

  const stories = [
    
    {
      imgSrc: "/images/profile/18.jpg",
      avatar: "/images/avatar/6.png",
      bgColor: "bg-success",
    },
  ];

  return (
    <div className="col-lg-5 col-xxl-6 col-box-5">
      <div className="content-wrapper">
        <div className={`${data === "1" ? "active" : ""} tabs-content`}>
          <div className="profile-content">
            
         
          </div>
        </div>
       
      </div>
    </div>
  );
};

export default FeaturedStories;
