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
  Progress,
} from "reactstrap";
import { IconPhotoHeart } from "@tabler/icons-react";
import { useAuth } from "@/lib/contexts/AuthContext";
import { updateProfile } from "@/lib/api";
import { useRouter } from "next/navigation";

function SettingProfile() {
  const { user, refreshUser } = useAuth();
  const router = useRouter();
  const [saving, setSaving] = useState(false);
  const [imageUploading, setImageUploading] = useState(false);
  const [imageProgress, setImageProgress] = useState(0);
  const [success, setSuccess] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const [formData, setFormData] = useState({
    full_name: "",
    avatar_url: "",
    company_name: "Web designer & Developer",
    phone_number: "",
    address: "",
    about_me: "",
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
      });
    }
  }, [user]);

  const handleChange = (
    e: React.ChangeEvent<
      HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement
    >
  ) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
  };

  const handleImageChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (!file) return;

    // Validate file type
    if (!file.type.startsWith("image/")) {
      setError("Please upload a valid image file.");
      return;
    }

    // Validate file size (max 2MB)
    if (file.size > 2 * 1024 * 1024) {
      setError("Image size must be less than 2MB.");
      return;
    }

    setImageUploading(true);
    setImageProgress(0);

    const reader = new FileReader();
    reader.onloadstart = () => {
      setImageProgress(10);
    };
    reader.onprogress = (event) => {
      if (event.lengthComputable) {
        setImageProgress(Math.round((event.loaded / event.total) * 90) + 10);
      }
    };
    reader.onload = () => {
      const dataUrl = reader.result as string;
      setImageProgress(100);
      setFormData((prev) => ({ ...prev, avatar_url: dataUrl }));
      setTimeout(() => {
        setImageUploading(false);
        setImageProgress(0);
      }, 500);
    };
    reader.onerror = () => {
      setImageUploading(false);
      setImageProgress(0);
      setError("Failed to read image file.");
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
      router.push("/apps/profile");
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
                    {imageUploading ? (
                      <div
                        className="d-flex align-items-center justify-content-center"
                        style={{
                          width: 120,
                          height: 120,
                          borderRadius: "50%",
                          backgroundColor: "#f8f9fa",
                        }}
                      >
                        <Progress
                          value={imageProgress}
                          striped
                          animated
                          className="w-75"
                        />
                      </div>
                    ) : (
                      <div
                        id="imgPreview"
                        style={{
                          width: 120,
                          height: 120,
                          borderRadius: "50%",
                          overflow: "hidden",
                          backgroundColor: "#f8f9fa",
                        }}
                      >
                        {formData.avatar_url ? (
                          <img
                            src={formData.avatar_url}
                            alt="Avatar"
                            style={{
                              width: "100%",
                              height: "100%",
                              objectFit: "cover",
                              display: "block",
                            }}
                          />
                        ) : (
                          <img
                            src={user?.profile?.avatar_url}
                            alt="Avatar"
                            style={{
                              width: "100%",
                              height: "100%",
                              objectFit: "cover",
                              display: "block",
                            }}
                          />
                        )}
                      </div>
                    )}
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
