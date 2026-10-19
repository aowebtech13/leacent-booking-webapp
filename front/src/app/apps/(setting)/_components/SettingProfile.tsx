"use client";
import React, { useState, useEffect } from "react";
import {
  Card,
  CardHeader,
  CardBody,
  Form,
  FormGroup,
  Label,
  Input,
  Button,
  Row,
  Col,
  Spinner,
  Alert,
} from "reactstrap";
import { IconPhotoHeart } from "@tabler/icons-react";
import { useAuth } from "@/lib/contexts/AuthContext";
import { updateProfile } from "@/lib/api";

function SettingProfile() {
  const { user, refreshUser } = useAuth();
  const [loading, setLoading] = useState(false);
  const [saving, setSaving] = useState(false);
  const [success, setSuccess] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const [formData, setFormData] = useState({
    full_name: "",
    avatar_url: "",
    company_name: "Web designer & Developer",
    phone_number: "",
    address: "",
    about_me: "",
    facebook_url: "",
    twitter_url: "",
    linkedin_url: "",
  });

  useEffect(() => {
    if (user) {
      setFormData({
        full_name: user.name || "",
        avatar_url: user.profile?.avatar_url || "",
        company_name: user.profile?.company_name || "Web designer & Developer",
        phone_number: user.profile?.phone_number || "",
        address: user.profile?.address || "",
        about_me: user.profile?.about_me || "",
        facebook_url: user.profile?.facebook_url || "",
        twitter_url: user.profile?.twitter_url || "",
        linkedin_url: user.profile?.linkedin_url || "",
      });
    }
  }, [user]);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
  };

  const handleImageChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = () => {
      const dataUrl = reader.result as string;
      setFormData((prev) => ({ ...prev, avatar_url: dataUrl }));
      document.getElementById("imgPreview")!.innerHTML = `<img src="${dataUrl}" alt="Avatar" className="img-fluid rounded-circle" style={{ width: 120, height: 120 }} />`;
    };
    reader.readAsDataURL(file);
  };

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setSaving(true);
    setError(null);
    setSuccess(false);

    try {
      await updateProfile(formData);
      setSuccess(true);
      await refreshUser();
    } catch (err: any) {
      setError(err?.message || "Failed to update profile");
    } finally {
      setSaving(false);
    }
  };

  return (
    <>
      <Card className="setting-profile-tab">
        <CardHeader>
          <h5>Profile</h5>
        </CardHeader>
        <CardBody>
          <div className="profile-tab profile-container">
            {/* Profile Picture Section */}
            <div className="image-details">
              <div className="profile-image"></div>
              <div className="profile-pic">
                <div className="avatar-upload">
                  <div className="avatar-edit">
                    <Input
                      type="file"
                      id="imageUpload"
                      accept=".png, .jpg, .jpeg"
                      onChange={handleImageChange}
                    />
                    <Label htmlFor="imageUpload">
                      <IconPhotoHeart size={16} />
                    </Label>
                  </div>
                  <div className="avatar-preview">
                    <div id="imgPreview">
                      {formData.avatar_url ? (
                        <img src={formData.avatar_url} alt="Avatar" className="img-fluid rounded-circle" style={{ width: 120, height: 120 }} />
                      ) : (
                        <img src={user?.profile?.avatar_url} alt="Avatar" className="img-fluid rounded-circle" style={{ width: 120, height: 120 }} />
                      )}
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {/* Personal Details */}
            <div className="person-details">
              <h5 className="fw-bold">
                {user?.name || "User"}{" "}
                {user?.profile?.email_verified_at && (
                  <img
                    width={20}
                    height={20}
                    src="/images/profile/01.png"
                    alt="verified"
                  />
                )}
              </h5>
              <p>{user?.profile?.company_name || "Web designer & Developer"}</p>
            </div>

            {/* User Info Form */}
            <Form className="app-form" onSubmit={handleSubmit}>
              {error && (
                <Alert color="danger" className="mb-3">
                  {error}
                </Alert>
              )}
              {success && (
                <Alert color="success" className="mb-3">
                  Profile updated successfully!
                </Alert>
              )}

              <h5 className="mb-2 text-dark fw-bold">User Info</h5>
              <Row>
                <Col md="12">
                  <FormGroup>
                    <Label>Username</Label>
                    <Input
                      type="text"
                      name="full_name"
                      value={formData.full_name}
                      readOnly
                      placeholder="Enter your name"
                    />
                  </FormGroup>
                </Col>
                <Col md="12">
                  <FormGroup>
                    <Label>Email address</Label>
                    <Input
                      type="email"
                      value={user?.email || ""}
                      disabled
                      placeholder="Email cannot be changed"
                    />
                  </FormGroup>
                </Col>
                <Col md="6">
                  <FormGroup>
                    <Label>Company Name</Label>
                    <Input
                      type="text"
                      name="company_name"
                      value={formData.company_name}
                      onChange={handleChange}
                      placeholder="Enter company name"
                    />
                  </FormGroup>
                </Col>
              </Row>

              {/* Divider */}
              <div className="app-divider-v dotted my-3"></div>

              <h5 className="mb-2 text-dark fw-bold">Personal Info</h5>
              <Row>
                <Col md="12">
                  <FormGroup>
                    <Label>Address</Label>
                    <Input
                      type="textarea"
                      name="address"
                      value={formData.address}
                      onChange={handleChange}
                      placeholder="Enter your address"
                    />
                  </FormGroup>
                </Col>
                <Col md="12">
                  <FormGroup>
                    <Label>About Me</Label>
                    <Input
                      type="textarea"
                      name="about_me"
                      value={formData.about_me}
                      onChange={handleChange}
                      placeholder="Tell us about yourself"
                    />
                  </FormGroup>
                </Col>
              
             
               
                <Col md="12">
                  <div className="text-end">
                    <Button color="primary" type="submit" disabled={saving}>
                      {saving ? <Spinner size="sm" /> : "Submit"}
                    </Button>
                  </div>
                </Col>
              </Row>
            </Form>
          </div>
        </CardBody>
      </Card>
    </>
  );
}

export default SettingProfile;
