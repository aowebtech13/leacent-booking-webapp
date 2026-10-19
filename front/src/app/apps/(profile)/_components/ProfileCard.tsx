import React from "react";
import { Card, CardBody, Row, Col, Button } from "reactstrap";
import { IconPhotoHeart, IconUser } from "@tabler/icons-react";
import Link from "next/link";

interface ProfileCardProps {
  user: {
    name?: string;
    email?: string;
    profile?: {
      avatar_url?: string | null;
      company_name?: string | null;
      phone_number?: string | null;
      address?: string | null;
      about_me?: string | null;
    } | null;
  } | null;
}

const ProfileCard = ({ user }: ProfileCardProps) => {
  const name = user?.name || "User";
  const company = user?.profile?.company_name || "Web designer & Developer";
  const avatar = user?.profile?.avatar_url || null;

  return (
    <Card>
      <CardBody>
        <Row className="profile-container">
          <div className="image-details">
            <div className="profile-image mb-2"></div>
            <div className="profile-pic">
              <div className="avatar-upload position-relative">
                <div className="avatar-edit position-absolute top-0 end-0">
                  <input
                    type="file"
                    id="imageUpload"
                    accept=".png, .jpg, .jpeg"
                    hidden
                  />
                  <label htmlFor="imageUpload" className="cursor-pointer">
                    <IconPhotoHeart size={16} />
                  </label>
                </div>
                <div className="avatar-preview mt-3">
                  <div id="imgPreview">
                    {avatar && <img src={avatar} alt="Avatar" className="img-fluid rounded-circle" style={{ width: 120, height: 120 }} />}
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div className="person-details">
            <h5 className="f-w-600">{name}</h5>
            <p>{company}</p>

            <div className="details">
              <Col>
                <h4 className="text-primary">0</h4>
                <p className="text-secondary">Books Read</p>
              </Col>
              <Col>
                <h4 className="text-primary">0</h4>
                <p className="text-secondary">Follower</p>
              </Col>
            
            </div>

            <div className="my-2">
              <Link href="/apps/setting">
                <Button color="primary" className="b-r-22">
                  <IconUser size={16} className="me-1" />
                  Edit Profile
                </Button>
              </Link>
            </div>
          </div>
        </Row>
      </CardBody>
    </Card>
  );
};

export default ProfileCard;
