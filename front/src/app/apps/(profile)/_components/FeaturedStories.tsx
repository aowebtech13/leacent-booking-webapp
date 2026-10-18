import React, { useState } from "react";
import { IconBrandHipchat } from "@tabler/icons-react";
import {
  Badge,
  Button,
  Card,
  CardBody,
  Col,
  Row,
} from "reactstrap";

interface FeaturedStoriesProps {
  data: string;
}

const FeaturedStories: React.FC<FeaturedStoriesProps> = ({ data }) => {
  const [dropdownOpen, setDropdownOpen] = useState(false);

  return (
    <div className="featured-stories">
      <h4>Featured Stories</h4>
      <p>Welcome to your profile stories section.</p>
    </div>
  );
};

export default FeaturedStories;
